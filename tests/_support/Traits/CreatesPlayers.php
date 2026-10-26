<?php

namespace Tests\Support\Traits;

use App\Entities\Hero;
use App\Entities\Player;
use App\Entities\User;
use App\Models\HeroModel;
use App\Models\PlayerModel;
use App\Models\UserModel;

/**
 * Fabrique les données de base dont presque tous les tests ont besoin :
 * un utilisateur Shield, son profil Player et, si besoin, des héros.
 */
trait CreatesPlayers
{
    protected function createUser(string $username = 'joueur1', string $password = 'Kaosmik2026!'): User
    {
        $users = model(UserModel::class);

        $users->save(new User([
            'username' => $username,
            'email' => $username . '@kaosmik.test',
            'password' => $password,
        ]));

        $user = $users->findById($users->getInsertID());
        $users->addToDefaultGroup($user);

        return $user;
    }

    protected function createPlayer(string $username = 'joueur1', array $overrides = []): Player
    {
        $user = $this->createUser($username);

        $playerModel = model(PlayerModel::class);
        $playerModel->save(new Player(array_merge(['user_id' => $user->id], $overrides)));

        return $playerModel->find($playerModel->getInsertID());
    }

    protected function getUserOf(Player $player): User
    {
        return model(UserModel::class)->findById($player->user_id);
    }

    protected function createHero(Player $player, array $overrides = []): Hero
    {
        $heroModel = model(HeroModel::class);

        $id = $heroModel->insert(new Hero(array_merge([
            'player_id' => $player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'Test Mercenaire',
            'power' => 20,
            'cost_credit' => 100,
        ], $overrides)));

        return $heroModel->find($id);
    }
}
