<?php

namespace App\Controllers;

use App\Models\UserSetting;
use App\Services\ResponseService;

class UserSettingController extends Controller
{
    private $userSettingModel;

    public function __construct()
    {
        $this->userSettingModel = new UserSetting();
    }

    public function get()
    {
        $user = $this->getAuthenticatedUser();
        $settings = $this->userSettingModel->getByUserId($user->id);

        if ($settings) {
            ResponseService::Send($settings);
        } else {
            ResponseService::Error("Settings not found", 404);
        }
    }

    public function update()
    {
        $user = $this->getAuthenticatedUser();
        $data = $this->decodePostData();

        $allowedFields = ['notifications', 'dark_mode', 'privacy_mode'];
        $fieldsToUpdate = [];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fieldsToUpdate[$field] = $data[$field];
            }
        }

        if (empty($fieldsToUpdate)) {
            ResponseService::Error("No valid fields to update", 400);
            return;
        }

        $currentSettings = $this->userSettingModel->getByUserId($user->id);
        $updatedData = array_merge($currentSettings, $fieldsToUpdate);

        $updated = $this->userSettingModel->updateByUserId($user->id, $updatedData);

        if ($updated) {
            ResponseService::Send(['message' => 'Settings updated successfully']);
        } else {
            ResponseService::Error('Failed to update settings', 500);
        }
    }
}
