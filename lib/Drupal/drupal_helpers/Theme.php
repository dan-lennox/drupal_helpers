<?php

namespace Drupal\drupal_helpers;

class Theme extends \Drupal\drupal_helpers\System {
  /**
   * Sets a theme as the default.
   */
  public static function setDefault($theme) {
    variable_set('theme_default', $theme);
  }

  /**
   * Sets a theme as the admin theme.
   */
  public static function setAdmin($theme) {
    variable_set('admin_theme', $theme);
  }

  /**
   * Enables a theme and performs some error checking.
   *
   * @param string $theme
   * @param bool $enable_dependencies
   *
   * @return bool
   *  - TRUE: Theme was enabled successfully.
   *
   * @throws \DrupalUpdateException
   */
  public static function enable($theme) {
    if (self::isEnabled($theme, 'theme')) {
      \Drupal\drupal_helpers\General::messageSet(format_string('Theme "@theme" already exists - Aborting!', array(
        '@theme' => $theme,
      )));

      return TRUE;
    }
    theme_enable(array($theme));

    // Double check that the theme installed.
    if (self::isEnabled($theme, 'theme')) {
      \Drupal\drupal_helpers\General::messageSet(format_string('Theme "@theme" was successfully enabled.', array(
        '@theme' => $theme,
      )));

      return TRUE;
    }

    throw new \DrupalUpdateException(format_string('Theme "@theme" could not enabled.', array(
      '@theme' => $theme,
    )));
  }

  /**
   * Disables a theme and performs some error checking.
   *
   * @param string $theme
   *
   * @return bool
   *  - TRUE: Theme was disabled successfully.
   *
   * @throws \DrupalUpdateException
   */
  public static function disable($theme) {
    if (self::isDisabled($theme, 'theme')) {
      \Drupal\drupal_helpers\General::messageSet(format_string('Theme "@theme" is already disabled - Aborting!', array(
        '@theme' => $theme,
      )));

      return TRUE;
    }

    theme_disable(array($theme));

    if (self::isDisabled($theme, 'theme')) {
      \Drupal\drupal_helpers\General::messageSet(format_string('Theme "@theme" was successfully disabled.', array(
        '@theme' => $theme,
      )));

      return TRUE;
    }

    throw new \DrupalUpdateException(format_string('Theme "@theme" could not disabled.', array(
      '@theme' => $theme,
    )));
  }
}