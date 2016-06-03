<?php

return [

    'stores' => [

        'ocs_session' => [
            'driver'  => 'ocs',
            'servers' => [
                [
                    'host' => "7cfbf02f0c274612.m.cnqdalicm9pub001.ocs.aliyuncs.com", 'port' => 11211, 'weight' => 100,
                ],
            ],
            'username' => '7cfbf02f0c274612',
            'password' => 'Afanwe2016'
        ],
        
        
        'ocs_cache' => [
	        'driver'  => 'ocs',
	        'servers' => [
                [
                    'host' => "27c4cbb947344daf.m.cnqdalicm9pub001.ocs.aliyuncs.com", 'port' => 11211, 'weight' => 100,
                ],
            ],
            'username' => '27c4cbb947344daf',
            'password' => 'Afanwe2016'
        ],



    ],


];
