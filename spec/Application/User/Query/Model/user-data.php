<?php

return [
	[
        "userId" => "2e6393b8-e554-4f90-9ba8-193b602029bb",
		"name" => "Filipe",
		"email" => "filipe.silva@sata.pt",
		"banned" => 1,
		"banReason" => "I need to test this! so Sorry!",
		"roles" => [1 => "ROLE_OAUTH2_USER", 2 => "ROLE_OAUTH2_VERIFIED_USER"]
	],
	[
        "userId" => "7d1bf257-531c-43c4-8816-718eec64196d",
		"name" => "John Doe",
		"email" => "john.doe@example.com",
		"banned" => 1,
		"banReason" => "Porque sim!",
		"roles" => []
	],
	[
        "userId" => "aa91b580-220d-46c9-816a-492138f251c8",
		"name" => "Filipe Silva",
		"email" => "silvam.filipe@gmail.com",
		"banned" => 0,
		"banReason" => null,
		"roles" => [1 => "ROLE_OAUTH2_USER", 2 => "ROLE_OAUTH2_VERIFIED_USER", 3 => "ROLE_OAUTH2_ADMIN"]
	]
];
