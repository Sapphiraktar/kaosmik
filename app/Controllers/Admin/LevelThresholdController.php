<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LevelThresholdModel;
use CodeIgniter\HTTP\ResponseInterface;

class LevelThresholdController extends BaseController
{
    private $levelThresholdModel;
    private $userModel;
    protected $layout = 'back';

    public function __construct()
    {
        $this->levelThresholdModel = model('LevelThresholdModel');
        $this->userModel = model('UserModel');
    }

    public function index()
    {
        $this->title = "Courbe des niveaux";

        $levelThresholds = $this->levelThresholdModel
            ->orderBy('level', 'ASC')
            ->findAll();

        $users = $this->userModel->findAll();

        return $this->render('admin/level-threshold/index', [
            'levelThresholds' => $levelThresholds,
            'users' => $users
        ]);
    }

    public function add()
    {
        $level = $this->request->getPost('level');
        $experienceRequired = $this->request->getPost('experience_required');

        $this->levelThresholdModel->insert([
            'level' => $level,
            'experience_required' => $experienceRequired
        ]);

        return redirect()->to(base_url('level'))->with(
            'success',
            'Le niveau ' . $level . ' a bien été ajouté.'
        );
    }



    public function delete() {
        $id = $this->request->getVar('id');
        if ($this->levelThresholdModel->delete($id)) {
            $this->success('Niveau supprimé');
        } else {
            $this->error("Erreur lors de la suppression du niveau");
        }
        return redirect()->to('/admin/level-treshold');
    }

    public function update() {
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        if ($this->levelThresholdModel->update($id, $data)) {
            $this->success('Niveau modifié');
        } else {
            $this->error("Erreur lors de la modification du niveau");
        }
        return $this->redirect('/admin/level-threshold');
    }
}
