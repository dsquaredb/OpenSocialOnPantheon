<?php

/**
 * @file
 * Contains \DrupalComposer\DrupalScaffold\FileFetcher.
 */

namespace DrupalComposer\DrupalScaffold;

<<<<<<< HEAD
use Composer\Util\Filesystem;
use Composer\Util\RemoteFilesystem;

class InitialFileFetcher extends FileFetcher {
=======
class InitialFileFetcher extends FileFetcher {

>>>>>>> revert Open Social update
  public function fetch($version, $destination) {
    array_walk($this->filenames, function ($filename, $sourceFilename) use ($version, $destination) {
      $target = "$destination/$filename";
      if (!file_exists($target)) {
        $url = $this->getUri($sourceFilename, $version);
        $this->fs->ensureDirectoryExists($destination . '/' . dirname($filename));
        $this->remoteFilesystem->copy($url, $url, $target);
      }
    });
  }
<<<<<<< HEAD
=======

>>>>>>> revert Open Social update
}
