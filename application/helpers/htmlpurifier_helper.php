<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Codeigniter HTMLPurifier Helper
 *
 * Purify input using the HTMLPurifier standalone class.
 * Easily use multiple purifier configurations.
 *
 * @author     Thulasiram Seelamsetty <thulasiram.soft@gmail.com>
 * @copyright  Public Domain
 * @license    MIT
 * @version         1.0.0
 *
 */
 /**
 http://htmlpurifier.org/download
Use the following code to purify using the default configuration:
$this->load->helper('htmlpurifier');
$clean_html = html_purify($dirty_html);
Where $dirty_html is a string, or an array of strings.

To use a custom configuration, pass the name of the configuration in the second parameter:
$clean_html = html_purify($dirty_html, 'comment');
 */
 
/**
 * @access  public
 * @param   string or array  $dirty_html  A string (or array of strings) to be cleaned.
 * @param   string           $config      The name of the configuration (switch case) to use.
 * @return  string or array               The cleaned string (or array of strings).
 */
if (! function_exists('html_purify'))
{
    function html_purify($dirty_html, $config = FALSE)
    {
        require_once APPPATH . 'third_party/htmlpurifier-4.6.0-standalone/HTMLPurifier.standalone.php';
        if (is_array($dirty_html))
        {
            foreach ($dirty_html as $key => $val)
            {
                $clean_html[$key] = html_purify($val, $config);
            }
        }
        else
        {
            $ci =& get_instance();
            switch ($config)
            {
                case 'comment':
                    $config = HTMLPurifier_Config::createDefault();
                    $config->set('Core.Encoding', $ci->config->item('charset'));
                    $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
                    $config->set('HTML.Allowed', 'p,a[href|title],abbr[title],acronym[title],b,strong,blockquote[cite],code,em,i,strike');
                    $config->set('AutoFormat.AutoParagraph', TRUE);
                    $config->set('AutoFormat.Linkify', TRUE);
                    $config->set('AutoFormat.RemoveEmpty', TRUE);
                    break;
                case FALSE:
                    $config = HTMLPurifier_Config::createDefault();
                    $config->set('Core.Encoding', $ci->config->item('charset'));
                    $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
                    break;
                default:
                    show_error('The HTMLPurifier configuration labeled "' . htmlentities($config, ENT_QUOTES, 'UTF-8') . '" could not be found.');
            }
            $purifier = new HTMLPurifier($config);
            $clean_html = $purifier->purify($dirty_html);
        }
        return $clean_html;
    }
}
/* End of htmlpurifier_helper.php */
/* Location: ./application/helpers/htmlpurifier_helper.php */