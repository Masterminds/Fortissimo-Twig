<?php
/**
 * @file
 * A Fortissimo Command to render a Twig template.
 */

/**
 * This command renders a Twig template.
 *
 * For more information on the API visit http://twig.sensiolabs.org/doc/api.html
 */
class SetupStringTemplates extends \Fortissimo\Command\Base {
  public function expects() {
    return $this->description('Setup a Twig enviornment that uses strings for templates.')
      ->usesParam('enviornment', 'A twig enviornment to render the template.')
        ->whichIsRequired()
      ->usesParam('template', 'The template to render. This can be a path to a template file for filesystem templates or a string for a template as a string.')
        ->withFilter('string')
        ->whichIsRequired()
      ->usesParam('variables', 'The variables to use in the template.')
        ->withFilter('array')
      ->usesParam('print', 'Whether to print the template or return the rendered output (defaults to TRUE).')
        ->withFilter('boolean')
      ->andReturns('If print is set to TRUE nothing is returned. If set to FALSE a string with the rendered template is returned.')
    ;
  }

  public function doCommand() {

    $enviornment = $this->param('enviornment');
    $template = $this->param('template');
    $variables = $this->param('variables', array());
    $print = $this->param('print', TRUE);

    $template = $enviornment->loadTemplate($template);

    $output = $template->render($variables);

    if ($print) {
      print $output;
    }
    else {
      return $output;
    }

  }
}