<?php

namespace Drupal\mild_media_manipulation\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "mild_media_manipulation",
 *   title = @Translation("Mild Media Manipulation"),
 *   description = @Translation("Wraps content with layout classes and optional captions."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE
 * )
 */
class MildMediaManipulation extends FilterBase {

  public function process($text, $langcode) {
    $pattern = '/\[mmm:\s*([a-zA-Z0-9_-]+)\s*\](.*?)\[\/mmm\]/s';

    $allowed = [
      'left-side',
      'right-side',
      'two-column',
      'centered',
    ];

    $callback = function ($matches) use ($allowed) {
      $variant = strtolower($matches[1]);
      $content = $matches[2];

      // Enforce controlled vocabulary.
      if (!in_array($variant, $allowed, TRUE)) {
        return $content;
      }

      // Split content and caption on first "|"
      $parts = explode('|', $content, 2);

      $main = trim($parts[0]);
      $caption = isset($parts[1]) ? trim($parts[1]) : '';

      $class = 'mmm mmm--' . $variant;

      // If caption exists → use <figure>
      if ($caption !== '') {
        return '<figure class="' . $class . '">' .
          $main .
          '<figcaption class="mmm__caption">' . $caption . '</figcaption>' .
          '</figure>';
      }

      // Otherwise → simple wrapper
      return '<div class="' . $class . '">' . $main . '</div>';
    };

    $processed = preg_replace_callback($pattern, $callback, $text);

    $result = new FilterProcessResult($processed);

    $result->setAttachments([
                              'library' => [
                                'mild_media_manipulation/styles',
                              ],
                            ]);

    return $result;
  }

}
