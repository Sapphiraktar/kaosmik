<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SpecializationController extends BaseController
{
    protected $layout = 'back';
    protected $current_menu = 'specialization';

    private $specializationModel;

    public function __construct()
    {
        $this->specializationModel = model('SpecializationModel');
    }

    public function index()
    {
        helper('form');

        $specializations = $this->specializationModel->findAll();

        return $this->render('admin/specialization/index', [
            'specializations' => $specializations
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();

        $saveOk = $this->specializationModel->insert($data);

        if ($saveOk) {
            $this->success('Spécialisation ajoutée');
        } else {
            $this->error('Une erreur est survenue, la spécialisation n\'est pas ajoutée.');
        }

        return $this->redirect('admin/specialization');
    }

    public function update()
    {
        $data = $this->request->getPost();

        $saveOk = $this->specializationModel->update($data['id'], $data);

        if ($saveOk) {
            $this->success('Spécialisation modifiée');
        } else {
            $this->error('Une erreur est survenue, la spécialisation n\'est pas modifiée.');
        }

        return $this->redirect('admin/specialization');
    }

    public function delete()
    {
        try {
            $id = $this->request->getPost('id');

            $deleteOk = $this->specializationModel->delete($id);

            if ($deleteOk) {
                $this->success('Spécialisation supprimée');
            } else {
                $this->error('Une erreur est survenue');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return $this->redirect('admin/specialization');
    }
}
