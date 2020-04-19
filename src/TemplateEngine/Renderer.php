<?php

namespace LoneCat\Framework\TemplateEngine;

use Closure;
use Throwable;

class Renderer
{
    private string $path;

    private ?string $extend;
    private array $blocks = [];
    private array $blockNames = [];

    public function __construct(string $path = 'templates')
    {
        $this->path = $path;
    }

    public function render(string $name, array $params = []): string
    {
        $level = ob_get_level();
        $templateFile = $this->path . '/' . $name . '.phtml';
        $this->extend = null;

        try {
            ob_start();
            extract($params, EXTR_OVERWRITE);
            include $templateFile;
            $content = ob_get_clean();
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend);
    }

    public function extend(?string $view): void
    {
        $this->extend = $view;
    }

    public function block(string $name, string $content): void
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    private function hasBlock(string $name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function ensureBlock(string $name): bool
    {
        if ($this->hasBlock($name)) {
            return false;
        }
        $this->beginBlock($name);
        return true;
    }

    public function beginBlock(string $name): void
    {
        $this->blockNames[] = $name;
        ob_start();
    }

    public function endBlock(): void
    {
        $content = ob_get_clean();
        $name = array_shift($this->blockNames);
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock(string $name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof Closure) {
            return $block();
        }

        return $block ?? '';
    }

    public function encode($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);

    }
}
