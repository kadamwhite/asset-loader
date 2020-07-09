<?php
/**
 * Test functions in the Asset_Loader\Manifest namespace.
 */

namespace Asset_Loader\Tests;

use Asset_Loader\Manifest;

class Test_Manifest extends Asset_Loader_Test_Case {
	/**
	 * Test get_manifest_resource() function.
	 *
	 * @dataProvider provide_get_manifest_resource_cases
	 */
	public function test_get_manifest_resource( string $manifest_path, string $resource, ?string $expected, string $message ) : void {
		$result = Manifest\get_manifest_resource( $manifest_path, $resource );
		$this->assertEquals( $expected, $result, $message );
	}

	/**
	 * Test cases for get_manifest_resource() utility function.
	 */
	public function provide_get_manifest_resource_cases() : array {
		$dev_manifest = dirname( __DIR__ ) . '/fixtures/devserver-asset-manifest.json';
		$prod_manifest = dirname( __DIR__ ) . '/fixtures/prod-asset-manifest.json';
		return [
			'dev manifest editor JS' => [
				$dev_manifest,
				'editor.js',
				'https://localhost:9090/build/editor.js',
				'editor resource dev URI should be retrieved from manifest',
			],
			'dev manifest frontend JS' => [
				$dev_manifest,
				'frontend-styles.js',
				'https://localhost:9090/build/frontend-styles.js',
				'frontend styles JS bundle dev URI should be retrieved from manifest',
			],
			'dev manifest invalid resource' => [
				$dev_manifest,
				'one-script-to-rule-them-all.js',
				null,
				'resources not included in the dev manifest should return null',
			],
			'prod manifest editor JS' => [
				$prod_manifest,
				'editor.js',
				'editor.03bfa96fd1c694ca18b3.js',
				'production editor JS path should be retrieved from manifest',
			],
			'prod manifest editor CSS' => [
				$prod_manifest,
				'editor.css',
				'editor.cce01a3e310944f3603f.css',
				'production editor CSS path should be retrieved from manifest',
			],
			'prod manifest frontend JS' => [
				$prod_manifest,
				'frontend-styles.js',
				null,
				'production frontend-styles JS bundle should not exist in manifest',
			],
			'prod manifest frontend CSS' => [
				$prod_manifest,
				'frontend-styles.css',
				'frontend-styles.96a500e3dd1eb671f25e.css',
				'production frontend-styles CSS path should be retrieved from manifest',
			],
			'prod manifest invalid resource' => [
				$prod_manifest,
				'one-script-to-rule-them-all.js',
				null,
				'resources not included in the production manifest should return null',
			],
		];
	}
}
