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
$aws_access_key = '';
$aws_secret_key = '';
$aws_session_token = 'IQoJb3JpZ2luX2VjEJb//////////wEaCXVzLXdlc3QtMiJHMEUCIEpUKBOG7u+NuqFwvGGbmo8tk5AFLs/fTSzNz4qbJmPqAiEAwflrqRw2s2yy5HuKaxCmmuJZseSgBplg4r2Rjk3WwSwqsgII3///////////ARABGgwxNjA1NDc2MDk4NjkiDHSkSlA7ne3hk6jLsiqGAu3pfvM8Z/Rh92sc0Ooz5J2TyGcQ4W+jyTlVJVV9fLUjha6zmfjBryc9n9wU09c3kOvc7A1f8WCA/5qOWeFuV0m83TRNHA6GyksA+Ziha7BajpYlOycCQJ3y2s/hH6/MXtjPdaUgx6tx7lMosm/WuvcyOa+Yb+uCTWaCEIwGaueCL14zUHIW3T0sznyo4i5nQM5P9q7hAGckgeLKLUOOggNRDBpdXUrgxPJdxv5R3x8Fqydx5/LlnjgKguruaGs9/jMTx6wJznboxFdnuJokzZTzLY/ofWLjyzPdn2BrvNM85v0jYcd/WkDtHoSRhHc6TGbq4ortlTmskOttUPu1wG6NHjOig9IwsajNvgY6nQGdoKUBBq6LI5SvKqa7SmK+BeJ7Jdk3SVh3POZtutinaBXkdNvm1aaLAgr4KVfdyrvBmdcuna8CJQdZoB0W4p/6kenb5GOFxAAXXhwOXiBAMHLR44C14MZLg5v13Ghl0Hgam4pojD6mBulokNQYunCg/3+k5AuMovbx35qf+iGDkp1u9hnjECH0+hIDjC8K1J4CqrB9oPfW3MfYuKYp';

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