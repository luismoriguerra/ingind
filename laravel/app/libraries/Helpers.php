<?php
//funciones
require_once app_path().'\libraries\htmltodocx_converter\h2d_htmlconverter.php';
require_once app_path().'\libraries\example_files\styles.inc';

class Helpers
{
  public static function generarWord($plantilla='Template.docx', 
                                     $nombreFile='Solarsystem.docx'
                                     )
  {

    $dir= public_path().'/docs/';
    $PHPWord = new PHPWord();

    $document = $PHPWord->loadTemplate($dir.'Template.docx');

    $document->setValue('Value1', 'Sun');
    $document->setValue('Value2', 'Mercury');
    $document->setValue('Value3', 'Venus');
    $document->setValue('Value4', 'Earth');
    $document->setValue('Value5', 'Mars');
    $document->setValue('Value6', 'Jupiter');
    $document->setValue('Value7', 'Saturn');
    $document->setValue('Value8', 'Uranus');
    $document->setValue('Value9', 'Neptun');
    $document->setValue('Value10', 'Pluto');

    $document->setValue('weekday', date('l'));
    $document->setValue('time', date('H:i'));

    $document->save($dir.'Solarsystem.docx');
  }
  public static function convertHtmlToWord( $html, $nombreFile )
  {

    // New Word Document:
    $phpword_object = new PHPWord();
    $section = $phpword_object->createSection();

    // HTML Dom object:
    $html_dom = new simple_html_dom();
    $html_dom->load('<html><body>' . $html . '</body></html>');
    // Note, we needed to nest the html in a couple of dummy elements.

    // Create the dom array of elements which we are going to work on:
    $html_dom_array = $html_dom->find('html',0)->children();

    // Provide some initial settings:
    $initial_state = array(
      // Required parameters:
      'phpword_object' => &$phpword_object, // Must be passed by reference.
      'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
      'base_path' => '/htmltodocx/', // Path from base_root to whatever url your links are relative to.
      
      // Optional parameters - showing the defaults if you don't set anything:
      'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
      'parents' => array(0 => 'body'), // Our parent is body.
      'list_depth' => 0, // This is the current depth of any current list.
      'context' => 'section', // Possible values - section, footer or header.
      'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
      'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
      'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
      'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
      'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
      'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
          
      // Optional - no default:    
      'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
      );    

    // Convert the HTML and put it into the PHPWord object
    htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

    // Clear the HTML dom object:
    $html_dom->clear(); 
    unset($html_dom);

    // Save File
    $h2d_file_uri = tempnam('', 'htd');
    $objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
    $objWriter->save($h2d_file_uri);

    // Download the file:
    /*header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=example.docx');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($h2d_file_uri));
    ob_clean();
    flush();
    $status = readfile($h2d_file_uri);
    unlink($h2d_file_uri);*/
    return $h2d_file_uri;
  }
}
