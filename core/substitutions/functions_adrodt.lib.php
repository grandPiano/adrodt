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
	static $rCustom = null;	
	
	if (method_exists($object, 'getIdContact'))
		$arrayidcontact = $object->getIdContact('external','SHIPPING');
	else
		$arrayidcontact = array();

	if(count($arrayidcontact)==0 && $object->origin!='') // search in origin doc
	{
		$object->fetch_origin();
		if(isset($object->{$object->origin}))
		{
			$origObj=$object->{$object->origin};
			if($origObj!=false && method_exists($origObj, 'getIdContact'))
					$arrayidcontact = $origObj->getIdContact('external','SHIPPING');
		}
	}

	if (count($arrayidcontact) > 0 && $object->fetch_contact($arrayidcontact[0]) == true)
	{
		$substitutionarray['adrodt_ship_name']		 	= trim($object->contact->firstname.' '.$object->contact->lastname);
		$substitutionarray['adrodt_ship_lastname'] 		= $object->contact->lastname;
		$substitutionarray['adrodt_ship_firstname'] 	= $object->contact->firstname;
		$substitutionarray['adrodt_ship_address'] 		= $object->contact->address;
		$substitutionarray['adrodt_ship_zip'] 			= $object->contact->zip;
		$substitutionarray['adrodt_ship_town'] 			= $object->contact->town;
		$substitutionarray['adrodt_ship_department'] 	= $object->contact->department;
		$substitutionarray['adrodt_ship_state'] 		= $object->contact->state;
		$substitutionarray['adrodt_ship_country'] 		= $object->contact->country;
		$substitutionarray['adrodt_ship_email'] 		= $object->contact->email;
		$substitutionarray['adrodt_ship_phone'] 		= $object->contact->phone_pro;
		$substitutionarray['adrodt_ship_fax'] 			= $object->contact->fax;
	}
	elseif(isset($object->client))
	{
		$substitutionarray['adrodt_ship_name']			= $object->client->name;
		$substitutionarray['adrodt_ship_lastname']		= '';
		$substitutionarray['adrodt_ship_firstname']		= '';
		$substitutionarray['adrodt_ship_address']		= $object->client->address;
		$substitutionarray['adrodt_ship_zip']			= $object->client->zip;
		$substitutionarray['adrodt_ship_town']			= $object->client->town;
		$substitutionarray['adrodt_ship_department']	= $object->client->department;
		$substitutionarray['adrodt_ship_state']			= $object->client->state;
		$substitutionarray['adrodt_ship_country']		= $object->client->country;
		$substitutionarray['adrodt_ship_email']			= $object->client->email;
		$substitutionarray['adrodt_ship_phone']			= $object->client->phone;
		$substitutionarray['adrodt_ship_fax']			= $object->client->fax;
	}
	elseif(isset($object->thirdparty))
	{
		$substitutionarray['adrodt_ship_name']			= $object->thirdparty->name;
		$substitutionarray['adrodt_ship_lastname']		= '';
		$substitutionarray['adrodt_ship_firstname']		= '';
		$substitutionarray['adrodt_ship_address']		= $object->thirdparty->address;
		$substitutionarray['adrodt_ship_zip']			= $object->thirdparty->zip;
		$substitutionarray['adrodt_ship_town']			= $object->thirdparty->town;
		$substitutionarray['adrodt_ship_department']	= $object->thirdparty->department;
		$substitutionarray['adrodt_ship_state']			= $object->thirdparty->state;
		$substitutionarray['adrodt_ship_country']		= $object->thirdparty->country;
		$substitutionarray['adrodt_ship_email']			= $object->thirdparty->email;
		$substitutionarray['adrodt_ship_phone']			= $object->thirdparty->phone;
		$substitutionarray['adrodt_ship_fax']			= $object->thirdparty->fax;
	}
	else
	{
		$substitutionarray['adrodt_ship_name']			= $substitutionarray['company_name'];
		$substitutionarray['adrodt_ship_lastname']		= '';
		$substitutionarray['adrodt_ship_firstname']		= '';
		$substitutionarray['adrodt_ship_address']		= $substitutionarray['company_address'];
		$substitutionarray['adrodt_ship_zip']			= $substitutionarray['company_zip'];
		$substitutionarray['adrodt_ship_town']			= $substitutionarray['company_town'];
		$substitutionarray['adrodt_ship_department']	= $substitutionarray['company_department'];
		$substitutionarray['adrodt_ship_state']			= $substitutionarray['company_state'];
		$substitutionarray['adrodt_ship_country']		= $substitutionarray['company_country'];
		$substitutionarray['adrodt_ship_email']			= $substitutionarray['company_email'];
		$substitutionarray['adrodt_ship_phone']			= $substitutionarray['company_phone'];
		$substitutionarray['adrodt_ship_fax']			= $substitutionarray['company_fax'];
	}

	
	if (method_exists($object, 'getIdContact'))
		$arrayidcontact = $object->getIdContact('external','BILLING');
	else
		$arrayidcontact = array();

	if(count($arrayidcontact)==0 && $object->origin!='') // search in origin doc
	{
		$object->fetch_origin();
		if(isset($object->{$object->origin}))
		{
			$origObj=$object->{$object->origin};
			if($origObj!=false && method_exists($origObj, 'getIdContact'))
					$arrayidcontact = $origObj->getIdContact('external','BILLING');
		}
	}
	
	if (count($arrayidcontact) > 0 && $object->fetch_contact($arrayidcontact[0]) == true)
	{
		$substitutionarray['adrodt_bill_name']			= trim($object->contact->firstname.' '.$object->contact->lastname);
		$substitutionarray['adrodt_bill_lastname'] 		= $object->contact->lastname;
		$substitutionarray['adrodt_bill_firstname'] 	= $object->contact->firstname;
		$substitutionarray['adrodt_bill_address'] 		= $object->contact->address;
		$substitutionarray['adrodt_bill_zip'] 			= $object->contact->zip;
		$substitutionarray['adrodt_bill_town'] 			= $object->contact->town;
		$substitutionarray['adrodt_bill_department']	= $object->contact->department;
		$substitutionarray['adrodt_bill_state'] 		= $object->contact->state;
		$substitutionarray['adrodt_bill_country'] 		= $object->contact->country;
		$substitutionarray['adrodt_bill_email'] 		= $object->contact->email;
		$substitutionarray['adrodt_bill_phone'] 		= $object->contact->phone_pro;
		$substitutionarray['adrodt_bill_fax'] 			= $object->contact->fax;
	}
	elseif(isset($object->client))
	{
		$substitutionarray['adrodt_bill_name']			= $object->client->name;
		$substitutionarray['adrodt_bill_lastname']		= '';
		$substitutionarray['adrodt_bill_firstname']		= '';
		$substitutionarray['adrodt_bill_address']		= $object->client->address;
		$substitutionarray['adrodt_bill_zip']			= $object->client->zip;
		$substitutionarray['adrodt_bill_town']			= $object->client->town;
		$substitutionarray['adrodt_bill_department']	= $object->client->department;
		$substitutionarray['adrodt_bill_state']			= $object->client->state;
		$substitutionarray['adrodt_bill_country']		= $object->client->country;
		$substitutionarray['adrodt_bill_email']			= $object->client->email;
		$substitutionarray['adrodt_bill_phone']			= $object->client->phone;
		$substitutionarray['adrodt_bill_fax']			= $object->client->fax;
	}
	elseif(isset($object->thirdparty))
	{
		$substitutionarray['adrodt_bill_name']			= $object->thirdparty->name;
		$substitutionarray['adrodt_bill_lastname']		= '';
		$substitutionarray['adrodt_bill_firstname']		= '';
		$substitutionarray['adrodt_bill_address']		= $object->thirdparty->address;
		$substitutionarray['adrodt_bill_zip']			= $object->thirdparty->zip;
		$substitutionarray['adrodt_bill_town']			= $object->thirdparty->town;
		$substitutionarray['adrodt_bill_department']	= $object->thirdparty->department;
		$substitutionarray['adrodt_bill_state']			= $object->thirdparty->state;
		$substitutionarray['adrodt_bill_country']		= $object->thirdparty->country;
		$substitutionarray['adrodt_bill_email']			= $object->thirdparty->email;
		$substitutionarray['adrodt_bill_phone']			= $object->thirdparty->phone;
		$substitutionarray['adrodt_bill_fax']			= $object->thirdparty->fax;
	}
	else
	{
		$substitutionarray['adrodt_bill_name']			= $substitutionarray['company_name'];
		$substitutionarray['adrodt_bill_lastname']		= '';
		$substitutionarray['adrodt_bill_firstname']		= '';
		$substitutionarray['adrodt_bill_address']		= $substitutionarray['company_address'];
		$substitutionarray['adrodt_bill_zip']			= $substitutionarray['company_zip'];
		$substitutionarray['adrodt_bill_town']			= $substitutionarray['company_town'];
		$substitutionarray['adrodt_bill_department']	= $substitutionarray['company_department'];
		$substitutionarray['adrodt_bill_state']			= $substitutionarray['company_state'];
		$substitutionarray['adrodt_bill_country']		= $substitutionarray['company_country'];
		$substitutionarray['adrodt_bill_email']			= $substitutionarray['company_email'];
		$substitutionarray['adrodt_bill_phone']			= $substitutionarray['company_phone'];
		$substitutionarray['adrodt_bill_fax']			= $substitutionarray['company_fax'];
	}
	
	//load extra substitution rules
	if ($rCustom == null)
	{
		$rCustom = readCustom('head');
	}
	
	if ($rCustom)
	{
		foreach($rCustom as $field => $value)
		{
			$substitutionarray[ $field ] = eval($value);
		}
	}
	
	$substitutionarray['adrodt_debug_object'] = print_r($substitutionarray, true);
	$substitutionarray['adrodt_dump_object'] = @print_r($object, true);
	
}

/** 		Function called to complete substitution array for lines (before generating on ODT, or a personalized email)
 * 		functions xxx_completesubstitutionarray_lines are called by make_substitutions() if file
 * 		is inside directory htdocs/core/substitutions
 * 
 *		@param	array		$substitutionarray	Array with substitution key=>val
 *		@param	Translate	$langs			Output langs
 *		@param	Object		$object			Object to use to get values
 *              @param  Object          $line                   Current line being processed, use this object to get values
 * 		@return	void					The entry parameter $substitutionarray is modified
 */
function adrodt_completesubstitutionarray_lines(&$substitutionarray,$langs,$object,$line)
{
    global $conf,$db;
	static $rCustom = null;
	static $extrafields = null;
	static $rExtraParams = array();
	
	if ($extrafields == null)
	{
		$extrafields = new ExtraFields($db);
		$extrafields->fetch_name_optionals_label($object->table_element_line);
		if ($extrafields->attribute_type)
		{
			foreach($extrafields->attribute_type as $field => $type)
			{
				if ($type == 'select')
				{
					$rExtraParams[ 'options_'.$field ] = $extrafields->attribute_param[ $field ]['options'];
				}
			}
		}
	}
	
	if(method_exists($line, 'fetch_optionals'))
	{
		$line->fetch_optionals($line->rowid);
		foreach($line->array_options as $options_key => $value)
		{
			if (isset($rExtraParams[ $options_key ]) && isset($rExtraParams[ $options_key ][ $value ]))
				$substitutionarray['line_'.$options_key] = $rExtraParams[ $options_key ][ $value ];
			else
				$substitutionarray['line_'.$options_key] = $value;
		}
	}
	
	//load extra substitution rules
	if ($rCustom == null)
	{
		$rCustom = readCustom('lines');
	}
	
	if ($rCustom)
	{
		foreach($rCustom as $field => $value)
		{
			$substitutionarray[ $field ] = eval($value);
		}
	}
	
	$substitutionarray['adrodt_debug_lines'] = 'Substitution Array: '."\n".print_r($substitutionarray, true);
	$substitutionarray['adrodt_dump_lines'] = 'Dump Line: '."\n" . @print_r($line, true);
	
}


function readCustom($type = 'head') {
	
	if ($type == 'head')
		$filename = __DIR__.'/../../customSubstitutionHead.csv';
	else
		$filename = __DIR__.'/../../customSubstitutionLines.csv';

	if (is_file($filename))
	{
		$fh = fopen($filename, 'r');
		if ( ! $fh)
			return false;
			
		$rSubstitution = array();
		while (($data = fgetcsv($fh, 1000, ";", '"')) !== false)
		{
			$rSubstitution[ $data[0] ] = $data[1];
		}
		return $rSubstitution;
	}
}
