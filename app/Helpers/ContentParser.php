<?php

namespace App\Helpers;

class ContentParser
{
    public static function appendInlineContent($content)
    {
        $element = '';
        if (is_array($content)) {
            if (isset($content['type'])) {
                $element .= self::createHTMLElement($content);
            } else {
                foreach ($content as $item) {
                    if (is_string($item)) {
                        $element .= htmlspecialchars($item);
                    } elseif (is_array($item)) {
                        $element .= self::appendInlineContent($item);
                    }
                }
            }
        } elseif (is_string($content)) {
            $element .= htmlspecialchars($content);
        }
        return $element;
    }

    public static function createHTMLElement($item)
    {
        $element = '';

        if (!isset($item['type'])) {
            return $element;
        }

        switch ($item['type']) {
            case 'text':
                $element .= '<p>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</p>';
                break;
            case 'bold':
                $element .= '<strong>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</strong>';
                break;
            case 'italic':
                $element .= '<em>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</em>';
                break;
            case 'underline':
                $element .= '<u>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</u>';
                break;
            case 'link':
                $element .= '<a href="' . htmlspecialchars($item['href']) . '">';
                $element .= self::appendInlineContent($item['text']);
                $element .= '</a>';
                break;
            case 'image':
                $element .= '<img src="' . htmlspecialchars($item['src']) . '" alt="' . htmlspecialchars($item['alt']) . '">';
                break;
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
                $element .= '<' . $item['type'] . '>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</' . $item['type'] . '>';
                break;
            case 'ul':
            case 'ol':
                $element .= '<' . $item['type'] . '>';
                foreach ($item['items'] as $listItem) {
                    $element .= '<li>';
                    $element .= self::appendInlineContent($listItem);
                    $element .= '</li>';
                }
                $element .= '</' . $item['type'] . '>';
                break;
            case 'table':
                $element .= '<table class="table table-bordered"><tbody>';
                foreach ($item['content'] as $row) {
                    $element .= '<tr>';
                    foreach ($row as $cell) {
                        $element .= '<' . $cell['type'] . ' rowspan="' . htmlspecialchars($cell['rowspan']) . '" colspan="' . htmlspecialchars($cell['colspan']) . '">';
                        $element .= self::appendInlineContent($cell['content']);
                        $element .= '</' . $cell['type'] . '>';
                    }
                    $element .= '</tr>';
                }
                $element .= '</tbody></table>';
                break;
            default:
                $element .= '<p>';
                $element .= self::appendInlineContent($item['content']);
                $element .= '</p>';
                break;
        }

        return $element;
    }
}
