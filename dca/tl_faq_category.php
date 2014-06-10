<?php
/**
 * PHP version 5
 * @copyright  Sven Rhinow Webentwicklung 2014 <http://www.sr-tag.de>
 * @author     Stefan Lindecke  <stefan@ktrion.de>
 * @author     Sven Rhinow <kservice@sr-tag.de>
 * @package    rms for Contao 3 (Release Management System)
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_faq_category
 */
if($GLOBALS['TL_CONFIG']['rms_active'])
{
	$GLOBALS['TL_DCA']['tl_faq_category']['config']['onload_callback'][] = array('tl_faq_category_rms','addRmsFields');
	$GLOBALS['TL_DCA']['tl_faq_category']['list']['operations']['editheader']['href'] = 'act=edit&table=tl_faq_category';
    
	// Palettes
	$GLOBALS['TL_DCA']['tl_faq_category']['palettes']['__selector__'][] = 'rms_protected';

	// Subpalettes
	$GLOBALS['TL_DCA']['tl_faq_category']['subpalettes']['rms_protected'] = 'rms_master_member';
    
	// Fields
	$GLOBALS['TL_DCA']['tl_faq_category']['fields']['rms_protected'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_faq_category']['rms_protected'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
	);
    $GLOBALS['TL_DCA']['tl_faq_category']['fields']['rms_master_member'] = array
    (
		'label'                   => &$GLOBALS['TL_LANG']['tl_faq_category']['rms_master_member'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'foreignKey'              => 'tl_user.name',
		'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
		'sql'                     => "int(10) unsigned NOT NULL default '0'",
		'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
    );
}

/**
 * Class tl_faq_category_rms
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package    Controller
 */
class tl_faq_category_rms extends \Backend
{
	/**
	* add RMS-Fields in enny news archive palettes (DCA)
	* @var object
	*/
	public function addRmsFields(\DataContainer $dc)
	{
	    //defined blacklist palettes
		$rm_palettes_blacklist = array('__selector__');

	    //add Field in meny content-elements
		foreach($GLOBALS['TL_DCA']['tl_faq_category']['palettes'] as $name => $field)
        {
			if(in_array($name,$rm_palettes_blacklist)) continue;

			$GLOBALS['TL_DCA']['tl_faq_category']['palettes'][$name] .=  ';{rms_legend:hide},rms_protected';
        }

	}
}