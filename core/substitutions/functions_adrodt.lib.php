<?php
/** 		Function called to complete substitution array (before generating on ODT, or a personalized email)
 * 		functions xxx_completesubstitutionarray are called by make_substitutions() if file
 * 		is inside directory htdocs/core/substitutions
 * 
 *		@param	array		$substitutionarray	Array with substitution key=>val
 *		@param	Translate	$langs			Output langs
 *		@param	Object		$object			Object to use to get values
 * 		@return	void					The entry parameter $substitutionarray is modified
 */
function adrodt_completesubstitutionarray(&$substitutionarray,$langs,$object)
{
   global $conf,$db;
 
   $myvalue='Put here calculated value to insert';
   $substitutionarray['adrodt_deliv_name']=$myvalue;
   $substitutionarray['adrodt_deliv_firstname']=$myvalue;
   
   
   /*
    * 
    * */
    $substitutionarray['myowntag'] = '';
    
	$usecontact=false;
	$arrayidcontact=$object->getIdContact('external','CUSTOMER');
	if (count($arrayidcontact) > 0)
	{
		$substitutionarray['myowntag'].=print_r($arrayidcontact, true);
		$usecontact=true;
		$result=$object->fetch_contact($arrayidcontact[0]);
	}
	
	$substitutionarray['myowntag'].='--------------------------------------------------------------------'.print_r($object->contact, true);
	$substitutionarray['myowntag'].='--------------------------------------------------------------------'.print_r($object, true);
   
}