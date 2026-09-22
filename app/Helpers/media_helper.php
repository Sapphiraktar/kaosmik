```php
<?php

if(!function_exists('upload_single_image')) {
    function uplaod_single_image(
            \CodeIgniter\Files\File $file,
            string $subfolder = '',
            string $custom_name = null,
            array $media_data = null,
            array $accepted_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'],
            int $max_size = 2048
    )
    {
        //1 vérification du fichier
        if ($file->getError() !== UPLOAD_ERR_OK) {
            return ['status'=> 'error', 'message'=> $file->getErrorString()];
        }
        if ($file->HasMoved()) {
            return ['status'=> 'error', 'message'=> 'Le fichier a déjà été déplacé. '];
        }
        $mime_type = $file->getClientMimeType();
        if(!in_array($mime_type, $accepted_mime_types)) {
            return ['status'=>'error', 'message' => 'Type de fichier non accepté. '];
        }

        if($file->getSize() > ($max_size * 1024)) {
            return ['status'=>'error', 'message' => 'Fichier trop volumineux. '];

        }
        //2 Définition du dossier de destination
        $year = date('Y');
        $month = date('m');
        $upload_path = FCPATH.'uploads/' . trim($subfolder, '/') . '/' .$year .'/' .$month;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0775, true);
        }

        //3 Génération du nom du fichier
        helper('text');
        $basename = $custom_name ? url_title($custom_name, '-', TRUE) : pathinfo($file->getName(), PATHINFO_FILENAME);
        $extension = $file->getExtension();
        $filename = $basename . '.' . uniqid() . '_' . $extension;

        //4 Déplacer le fichier
        $file->move($upload_path, $filename);
        $relativePath = 'uploads/' . trim($subfolder, '/') . '/' .$year . '/' .$month . '/' .$filename;

        //5 Stocker dans la BDD
        $mediaModel = model('MediaModel');
        $existing = $mediaModel->where('entity_type', $media_data['entity_type'])
                ->where('entity_id', $media_data['entity_id'])
                ->first();
        if($existing) {
            if($existing->fileExists()) {
                @unlink($existing->getAbsolutePath());
            }
            $mediaModel->update($existing->id, ['url' => $relativePath,'name'=> $basename, 'type' => $mime_type] + $media_data);
            return $mediaModel->find($existing->id);
        }
        $newId = $mediaModel->insert($media_data + ['url' => $relativePath, 'name' => $basename, 'type' => $mime_type], true);
        return $mediaModel->find($newId);
    }
}
