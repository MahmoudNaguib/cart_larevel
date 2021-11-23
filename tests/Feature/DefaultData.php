<?php
namespace Tests\Feature;
use BasicSeeder;


trait DefaultData{
    public $adminUser;
    public function setup():void{
        parent::setup();
        $this->seed(BasicSeeder::class);
        $this->adminUser= \App\Models\User::find(1);
        $this->user= \App\Models\User::find(2);
    }
    public function actingAsAdmin() {
        $this->actingAs($this->adminUser);
    }
    public function actingAsApi() {
        $this->withHeaders(['token' => $this->user->token]);
    }

}
