<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RarityLevelController extends BaseController
{
    protected $layout = "back";

    private $rarityLevelModel;
    private $userModel;

    protected $current_menu = 'rarity-level';

    public function __construct()
    {
        $this->rarityLevelModel = model("RarityLevelModel");
        $this->userModel = model("UserModel");
    }

    public function index()
    {
        helper('form');

        $this->title = "Niveaux de rareté";

        $rarityLevels = $this->rarityLevelModel
            ->orderBy('id', 'ASC')
            ->findAll();

        $users = $this->userModel->findAll();

        return $this->render('admin/rarity-level/index', [
            'rarityLevels' => $rarityLevels,
            'users' => $users
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->rarityLevelModel->insert($data)) {
            $this->success("La rareté " . $data['name'] . " a été créée avec succès.");
        } else {
            $this->error("Une erreur est survenue lors de la création de la rareté.");
        }

        return $this->redirect('/admin/rarity-level');
    }

    public function update()
    {
        $data = $this->request->getPost();

        if (!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('/admin/rarity-level');
        }

        $id = $data['id'];
        unset($data['id']);

        $rarityLevel = $this->rarityLevelModel->find($id);

        if ($rarityLevel === null) {
            $this->error('Rareté introuvable dans la base de données.');
            return $this->redirect('/admin/rarity-level');
        }

        if ($this->rarityLevelModel->update($id, $data)) {
            $this->success('Rareté modifiée avec succès.');
        } else {
            $this->error('Une erreur est survenue lors de la modification de la rareté.');
        }
        return $this->redirect('/admin/rarity-level');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            $this->error('Identifiant inconnu');
            return $this->redirect('/admin/rarity-level');
        }

        $rarityLevel = $this->rarityLevelModel->find($id);

        if ($rarityLevel === null) {
            $this->error('Rareté introuvable dans la base de données.');
            return $this->redirect('/admin/rarity-level');
        }

        if ($this->rarityLevelModel->delete($id)) {
            $this->success('Rareté supprimée avec succès.');
        } else {
            $this->error('Erreur lors de la suppression de la rareté.');
        }
        return $this->redirect('/admin/rarity-level');
    }
}

