<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\License;
use App\Services\GitHub\GitHubApi;
use Exception;

class DownloadLatestReleaseForExpiredLicenseController
{
    public function __invoke(License $license, string $repo)
    {
        $repo = "spatie/{$repo}";

        if (! $license->isAssignedTo(current_user())) {
            abort(403, "License {$license->id} is not assigned to user id" . current_user()->id);
        }

        if (! $license->isExpired()) {
            throw new Exception("This license has not expired yet.");
        }

        if (! $license->coversRepo($repo)) {
            abort(403, "License id {$license->id} does not cover repo `{$repo}`");
        }


        $temporaryDownloadUrl = app(GitHubApi::class)
            ->temporaryUrlOfLatestAvailableRelease(
                $repo,
                $license->expired_at
            );

       return response()->redirectTo($temporaryDownloadUrl);
    }
}
