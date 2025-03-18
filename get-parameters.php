<?php
// Enable error logging
error_log('Retrieving settings from AWS Parameter Store');

// Load AWS SDK
require 'vendor/autoload.php';

use Aws\Ssm\SsmClient;
use Aws\Exception\AwsException;

// Set AWS Region
$region = 'us-east-1';

// AWS Temporary Credentials
$aws_access_key = 'YOUR_ACCESS_KEY';
$aws_secret_key = 'YOUR_SECRET_KEY';
$aws_session_token = 'YOUR_SESSION_TOKEN';

// Initialize AWS SSM Client
$ssm_client = new SsmClient([
  'version' => 'latest',
  'region'  => $region,
  'credentials' => [
      'key'    => $aws_access_key,
      'secret' => $aws_secret_key,
      'token'  => $aws_session_token // Required for temporary credentials
  ]
]);

try {
  // Retrieve parameters from AWS Systems Manager (SSM) Parameter Store
  $result = $ssm_client->getParametersByPath([
      'Path' => '/onlinecafe/', // Change to your actual path
      'WithDecryption' => true
  ]);

  $values = [];

  // Extract parameters
  foreach ($result['Parameters'] as $p) {
      $key = str_replace('/onlinecafe/', '', $p['Name']);
      $values[$key] = $p['Value'];
  }

  // Assign extracted values safely
  $ep = $values['endpoint'] ?? '';
  $un = $values['username'] ?? '';
  $pw = $values['password'] ?? '';
  $db = $values['database'] ?? '';

} catch (AwsException $e) {
  error_log("AWS SSM Parameter Store Error: " . $e->getMessage());
  $ep = $db = $un = $pw = '';
}
?>