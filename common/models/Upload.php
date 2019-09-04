<?php
namespace common\models;

use Yii;
use yii\helpers\Url;
use limion\jqueryfileupload\JQueryFileUpload;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\db\Expression;

class Upload
{
   
	public static function fileInput($model, $attr, $image = false, $multiple = false, $redirect = false){
		$accept = '/*';
		if($image){
			$accept = 'image/*';
		}
		if($multiple){
			$view = '@frontend/views/upload/main-multiple';
		}else{
			$view = '@frontend/views/upload/main';
		}
		
		
		$max = 0;
		$ext = array();
		foreach ($model->getActiveValidators($attr. '_instance') as $validator) {			
			if ($validator instanceof yii\validators\FileValidator && $validator->maxSize !== null) {
				$max = $validator->maxSize;
			}
			
			if ($validator instanceof yii\validators\FileValidator && $validator->extensions !== null) {
				$ext = $validator->extensions;
			}
			
			if($ext and $max > 0){
				break;
			}
		}
		
		
		$str_ext = '';
		if($ext){
			$i = 1;
			foreach($ext as $ex){
				$comma = $i == 1 ? '' : ', ';
				$str_ext .= $comma.$ex;
				$i++;
			}
		}

		
		$result =  JQueryFileUpload::widget([
		'model' => $model,
        'attribute' => $attr . '_instance',
        'url' => [$model->file_controller . '/upload', 'attr'=> $attr, 'id' => $model->id],
        'appearance'=>'plus', // available values: 'ui','plus' or 'basic'
		'mainView'=> $view, 
        'name' => 'file',
        'options' => [
            'accept' => $accept,
			'multiple' => false,
			'id' =>  $attr."_".$model->id
        ],
        'clientOptions' => [
            'dataType' => 'json',
            'autoUpload'=>true
        ],
        'clientEvents' => [
			'add' => "function (e, data){
				$('#errors_".$attr."_".$model->id ."').text('');
				var client_valid = true;
				
				if(client_valid){
					var max = '".$max."'; 
					var size = data.files[0].size;
					if(size > max){
						$('#errors_".$attr."_".$model->id ."').text('The file size (' + size + ') exceed allowed maximum size of (' + max + ')');
						return false;
					}
					var fileType = data.files[0].name.split('.').pop(), allowdtypes = '".$str_ext."';
						if (allowdtypes.indexOf(fileType) < 0) {
							$('#errors_".$attr."_".$model->id ."').text('Invalid file type, allowed only ' + allowdtypes);
							return false;
						}
				}
				
				$('#btn_".$attr."_".$model->id ."').hide();	
				$('#progress_".$attr."_".$model->id ."').show();
				
			}",
            'done'=> "function (e, data) {
				console.log(data);
				var files = data.result.files;
				if(files){
					
					$('#btn_".$attr."_".$model->id ."').hide();
					$('#file_".$attr."_".$model->id ."').show();
					$('#remove_db_".$attr."_".$model->id ."').hide();
					$('#action_".$attr."_".$model->id ."').show();
					var ext = name.split('.').pop();
					var src;
					if(data.result.files[0].ext == 'pdf'){
						src = '" . Url::to('@web/images/')."pdf.png';
					}else{
						src = files[0].url + '?r='+ Math.random();
					}
					$('#img_".$attr."_".$model->id ."').html('<a href=\" ' + files[0].url + '?r='+ Math.random() +'\" target=\"_blank\" ><img src=\" ' + src +'\" width=\"60\" /></a>');
					
					
				}else{
					$('#btn_".$attr."_".$model->id ."').show();
					var error = data.result.errors.".$attr."_instance;
					$('#errors_".$attr."_".$model->id ."').text(error[0]);
					$('#btn_".$attr."_".$model->id ."').show();
				}
				
				$('#progress_".$attr."_".$model->id ."').hide();
				
            }",
            'progressall'=> "function (e, data) {
				
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress_".$attr."_".$model->id ." .progress-bar').css(
                    'width',
                    progress + '%'
                );
				$('#progress_".$attr."_".$model->id ." .progress-bar').text(progress + '%');
            }",
			
			
        ]
    ]);
	
	return $result;

	}
	
	
	public static function upload($model, $attr, $ts = false){
		$model->scenario = $attr . '_upload';

		$instance = $attr . '_instance';
		$attr_db = $attr . '_file';
		
		$upFile = UploadedFile::getInstance($model, $instance);
		
		$model->{$instance} = $upFile;
		$uid = uniqid(time(), true);
		
		$ext = $upFile->extension;
		
		$fileName = $attr . '_' . $uid . '.' . $ext;
		
		$year = date('Y') + 0 ;
		$path = $year . '/' . Yii::$app->user->identity->username .  '/' ;
		
		$directory = Yii::getAlias('@upload/' . $path . '/');
		$filePath = $directory . $fileName;
		$model->{$attr_db} = $path . $fileName;
		if($ts){
			$model->{$ts} = new Expression('NOW()');
		}
		
		if (!is_dir($directory)) {
			FileHelper::createDirectory($directory);
		}
		
		//$model->save();
		/* return Json::encode([
						'errors' => $model->getErrors(),
					]); */
		if($model->save()){
			
			if ($upFile) {
			
			if ($upFile->saveAs($filePath)) {
				
				$path = Url::to([ $model->file_controller . '/download', 'attr' => $attr, 'id' => $model->id]);
				$path_delete = Url::to([$model->file_controller . '/delete', 'attr' => $attr, 'id' => $model->id]);
				//saving in database
				
				
				
					return Json::encode([
						'files' => [
							[
								//'name' => $fileName,
								'size' => $upFile->size,
								'url' => $path,
								'ext' => $ext,
								'thumbnailUrl' => $path,
								'deleteUrl' => $path_delete,
								'deleteType' => 'POST',
							],
						],
					]);
				
				
				
			}
		
		}
			
		}else{
			return Json::encode([
						'errors' => $model->getErrors(),
					]);
		}
		

		return '';
	}
	
	public static function download($model, $attr, $filename){
		
		$attr_db = $attr . '_file';
		
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
        if (file_exists($file)) {
		$ext = pathinfo($model->{$attr_db}, PATHINFO_EXTENSION);

		$filename = $filename . '.' . $ext ;
		
		self::sendFile($file, $filename, $ext);
		
		
		}
		
		
	}
	
	public static function sendFile($file, $filename, $ext){
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: inline; filename=" . $filename);
		header("Content-Type: " . self::mimeType($ext));
		header("Content-Length: " . filesize($file));
		header("Content-Transfer-Encoding: binary");
		readfile($file);
		exit;
	}
	
	public static function mimeType($ext){
		switch($ext){
			case 'pdf':
			$mime = 'application/pdf';
			break;
			
			case 'jpg':
			case 'jpeg':
			$mime = 'image/jpeg';
			break;
			
			case 'gif':
			$mime = 'image/gif';
			break;
			
			case 'png':
			$mime = 'image/png';
			break;
			
			default:
			$mime = '';
			break;
		}
		
		return $mime;
	}
	
	public static function showFile($model, $attr, $controller){
		$db_file = $attr . '_file';
		if($model->{$db_file}){
			//pdf Url::to('@web/images/')
			$ext = pathinfo($model->{$db_file}, PATHINFO_EXTENSION);
			if($ext == 'pdf'){
				$link = Url::to('@web/images/') . 'pdf.png';
			}else{
				$link = Url::to([$controller . '/download', 'attr' => $attr, 'id' => $model->id]);
			}
			
			return '<a href="'. Url::to([$controller . '/download', 'attr' => $attr, 'id' => $model->id]) . '" target="_blank">
			<img src="'. $link . '" width="40" /></a>';
			
			
		}
		
		
	}
}
