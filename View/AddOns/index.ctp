<?php
    $client_id = 'ht9gcr7e7sb3qjm759ad2gm5';
    $client_secret = 'Fn5SkWECRqguTU9NadnaYnZr';
    $redirect_uri = urlencode('http://localhost/add_ons/myob');
    $response_type = 'code';
    $scope = 'CompanyFile';

    $params = 'client_id='.$client_id.'&redirect_uri='.$redirect_uri
        .'&response_type='.$response_type.'&scope='.$scope;
 ?>
<H1>Test</H1>
<a href="https://secure.myob.com/oauth2/account/authorize?<?php echo $params; ?>">Myob</a>
