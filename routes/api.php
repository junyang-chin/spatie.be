<?php

use App\Http\Api\Controllers\Activations\CreateActivationController;
use App\Http\Api\Controllers\Activations\DeleteActivationController;
use App\Http\Api\Controllers\Activations\ShowActivationController;
use App\Http\Api\Controllers\Activations\UpdateCurrentVersionController;
use App\Http\Api\Controllers\BundlePriceController;
use App\Http\Api\Controllers\HandleGitHubPullRequestWebhookController;
use App\Http\Api\Controllers\HandleGitHubRepositoryWebhookController;
use App\Http\Api\Controllers\HelpSpaceController;
use App\Http\Api\Controllers\MembersController;
use App\Http\Api\Controllers\PlainController;
use App\Http\Api\Controllers\PriceController;
use App\Http\Api\Controllers\SatisAuthenticationController;
use App\Http\Api\Controllers\ShowLicenseController;
use App\Http\Auth\Controllers\ApiTokensController;
use App\Http\Middleware\IsValidHelpSpaceRequest;
use Illuminate\Support\Facades\Route;

Route::post('satis/authenticate', SatisAuthenticationController::class)->middleware(['forceJson', 'auth:license-api'],);

Route::prefix('webhooks')->group(function () {
    Route::post('github', HandleGitHubRepositoryWebhookController::class);
    Route::post('github/pull-requests', HandleGitHubPullRequestWebhookController::class);
});

Route::post('activations', CreateActivationController::class);
Route::post('activations/{activation:uuid}/show', ShowActivationController::class);
Route::post('activations/{activation:uuid}/version', UpdateCurrentVersionController::class);
Route::delete('activations/{activation:uuid}', DeleteActivationController::class);

Route::get('price/{purchasable}/{ipOrCountryCode?}', PriceController::class);
Route::get('bundle-price/{bundle}/{ipOrCountryCode}', BundlePriceController::class);


Route::get('license/{license:key}', ShowLicenseController::class);

Route::get('members', [MembersController::class, 'index'])->middleware(['auth:sanctum', 'adminsOnly']);

Route::post('tokens', [ApiTokensController::class, 'create'])->middleware('adminsOnly');
