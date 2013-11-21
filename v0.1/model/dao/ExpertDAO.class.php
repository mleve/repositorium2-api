<?php

interface ExpertsDAO{

	public function create($expert,$criteria);
	
	public function getExpertCriteria($user);
	
	public function getExpertForCriteria($criteria);
}
?>