<?php

namespace common\models;

class ClaimWorkflow implements \raoul2000\workflow\source\file\IWorkflowDefinitionProvider
{
	
	public function getDefinition() {
		return [
			'initialStatusId' => 'aa-draft',
			'status' => [
			
				'aa-draft' => [
					'label' => 'Deraf',
					'transition' => ['bb-submit'],
					'metadata' => [
						'color' => 'danger',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'bb-submit' => [
					'label' => 'Hantar',
					'transition' => ['cc-returned'],
					'metadata' => [
						'color' => 'success',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'cc-returned' => [
					'label' => 'Dikembalikan',
					'transition' => ['bb-submit'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
			

				]
			]
			;
	}
}






?>