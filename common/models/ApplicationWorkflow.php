<?php

namespace common\models;

class ApplicationWorkflow implements \raoul2000\workflow\source\file\IWorkflowDefinitionProvider
{
	
	public function getDefinition() {
		return [
			'initialStatusId' => 'a-draft',
			'status' => [
				'a-draft' => [
					'label' => 'Deraf',
					'transition' => ['b-submit'],
					'metadata' => [
						'color' => 'danger',
						//'icon' => 'fa fa-bell'
					]
				],
				'b-submit' => [
					'label' => 'Dalam Proses',
					'transition' => ['c-verified', 'g-returned'],
					'metadata' => [
						'color' => 'info',
						//'icon' => 'fa fa-bell'
					]
				],
				'c-verified' => [
					'label' => 'Disokong',
					'transition' => ['d-approved', 'b-submit'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'd-approved' => [
					'label' => 'Lulus',
					'transition' => ['e-release'],
					'metadata' => [
						'color' => 'success',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'e-release' => [
					'label' => 'Surat Tawaran',
					'transition' => ['f-accept'],
					'metadata' => [
						'color' => 'info',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'f-accept' => [
					'label' => 'Aktif',
					'metadata' => [
						'color' => 'primary',
						//'icon' => 'fa fa-bell'
					]
				]
				,
				'g-returned' => [
					'label' => 'Dikembali',
					'transition' => ['b-submit'],
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