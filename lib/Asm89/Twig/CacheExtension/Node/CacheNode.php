<?php

/*
 * This file is part of twig-cache-extension.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm89\Twig\CacheExtension\Node;

/**
 * Cache twig node.
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class CacheNode extends \Twig_Node
{
    private static $cacheCount = 1;
    private $hash = '';

    /**
     * @param \Twig_Node_Expression $annotation
     * @param \Twig_Node_Expression $keyInfo
     * @param \Twig_NodeInterface   $body
     * @param integer               $lineno
     * @param string                $tag
     */
    public function __construct(\Twig_Node_Expression $annotation, \Twig_Node_Expression $keyInfo, \Twig_NodeInterface $body, $lineno, $tag = null)
    {
        parent::__construct(array('key_info' => $keyInfo, 'body' => $body, 'annotation' => $annotation), array(), $lineno, $tag);
    }

    private function hashIncludeNode($node, $env)
    {
        if ($node === null) {
            return;
        }

        if ($node->getNodeTag() === 'include') {
            $template = $env->getLoader()->getSource($node->getNode('expr')->getAttribute('value'));
            $this->hash = sha1($this->hash.$template);
        }

        foreach ($node as $n) {
            $this->hashIncludeNode($n, $env);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $i = self::$cacheCount++;

        $this->hash = '';
        $this->hashIncludeNode($this->getNode('body'), $compiler->getEnvironment());
        $hash = sha1($this->hash.$this->getNode('body'));

        $compiler
            ->addDebugInfo($this)
            ->write("\$asm89CacheStrategy".$i." = \$this->getEnvironment()->getExtension('asm89_cache')->getCacheStrategy();\n")
            ->write("\$asm89Key".$i." = \$asm89CacheStrategy".$i."->generateKey(")
                ->subcompile($this->getNode('annotation'))
                ->raw(", ")
                ->subcompile($this->getNode('key_info'))
            ->write(");\n")
            ->write("if (isset(\$asm89Key".$i."['key']['key'])) {\n")
                ->indent()
                    ->write("\$asm89Key".$i."['key']['key'] .= '/h/".$hash."';\n")
                ->outdent()
            ->write("} else {\n")
                ->indent()
                    ->write("\$asm89Key".$i."['key'] .= '/h/".$hash."';\n")
                ->outdent()
            ->write("}\n")
            ->write("\$asm89CacheBody".$i." = \$asm89CacheStrategy".$i."->fetchBlock(\$asm89Key".$i.");\n")
            ->write("if (\$asm89CacheBody".$i." === false) {\n")
            ->indent()
                ->write("ob_start();\n")
                    ->indent()
                        ->subcompile($this->getNode('body'))
                    ->outdent()
                ->write("\n")
                ->write("\$asm89CacheBody".$i." = ob_get_clean();\n")
                ->write("\$asm89CacheStrategy".$i."->saveBlock(\$asm89Key".$i.", \$asm89CacheBody".$i.");\n")
            ->outdent()
            ->write("}\n")
            ->write("echo \$asm89CacheBody".$i.";\n")
        ;
    }
}
