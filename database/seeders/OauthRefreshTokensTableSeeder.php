<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OauthRefreshTokensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('oauth_refresh_tokens')->delete();

        \DB::table('oauth_refresh_tokens')->insert([
            0 => [
                'access_token_id' => '4fd34c125410fe77fc96160090b6d734ba1fcaf40f430f637a0cec6fd4615450eedd94b403d66389',
                'expires_at' => '2023-01-10 06:57:31',
                'id' => '049c60341379d351fbe58ab5cf35edd1ce5d60d4b4a7c043ead5131dbc0245f0648a7e9667bd2e4b',
                'revoked' => 0,
            ],
            1 => [
                'access_token_id' => 'bf400ad1c3d0457c7f9c99ec2d6c3b76698490c6f2e096243a174ebb6fb5ba026a3e7f27c5b48642',
                'expires_at' => '2023-01-14 04:28:04',
                'id' => '05149cfcec84b68146c2fde4b6025cf7b92cb11b6428ed52a4b565d93dbba3e39b0875544a1adf29',
                'revoked' => 0,
            ],
            2 => [
                'access_token_id' => 'ed987f5058c6a4ba0ae78fa5abd829f098350b97e61a75395d75f7b419afeb9571ffa0b2328dc804',
                'expires_at' => '2023-01-14 01:19:06',
                'id' => '061602f3d1f20547ef8a3f8b41f3ee57723e823c238ed68e159fdd4671d9f5a103b01f0cbea6ef0c',
                'revoked' => 0,
            ],
            3 => [
                'access_token_id' => '8b89cb013071ded472cdf5489a00829d6569ba8ab9d65e5838cfecb965b79370e433cf9bd1b698c9',
                'expires_at' => '2023-01-12 22:47:53',
                'id' => '07958f6424b4d003831faaf7072c16ea2dcc426011e61fcc63023a3778e564cc7e7a388365e592a8',
                'revoked' => 0,
            ],
            4 => [
                'access_token_id' => '8d436273b7d3cbbb6564a5a121cb395c9a141a6bf77e6217faff77522a5ba150b1c76999e11a4d26',
                'expires_at' => '2023-01-13 22:52:47',
                'id' => '10fab0d22176e1f596caac83163c165623748081ada15f24266d83c7c27f555a05c6a3f6debf217c',
                'revoked' => 0,
            ],
            5 => [
                'access_token_id' => 'd95bc0c8bd77017c72da4f8ec3f5b80ec8a035994569bcfdfaad3d6bb9d4a318dc4431d0d0e21fb0',
                'expires_at' => '2023-01-10 06:18:19',
                'id' => '1405e1ad5567ff8df2c5e7867daf3671acc3465f8cc86249b9711d8f45a9868ce12d6026ba6517e6',
                'revoked' => 0,
            ],
            6 => [
                'access_token_id' => '41419dfe93244d5f42decb84d4971445669fc596028409479bc4bada9c64aeefcfcd554a5b23ac87',
                'expires_at' => '2023-01-14 00:39:16',
                'id' => '1486805e3ccbeb7e00802533384f7f66ceaa5fb6a5908349e6ed0f22192a00f5bdd0f7f515a64d05',
                'revoked' => 0,
            ],
            7 => [
                'access_token_id' => 'a33aef7999c71175e4d75095ed5e9183e50c90cb6f96fdb40d0457840966893ccf2807c0caca7eb0',
                'expires_at' => '2023-01-13 22:48:04',
                'id' => '18256cdbd0e8ea5dc4e205a6273d23ea6d1c0131cbdad638859f742f9b4e5dfc3a6bd8938b396e41',
                'revoked' => 0,
            ],
            8 => [
                'access_token_id' => 'c2c66b8b5d2d91f15d31b8d3963e9c96e3d1ceef8597ee997d1abf40659478104351a8780d73fc8f',
                'expires_at' => '2023-01-13 22:46:20',
                'id' => '1f9efb1708e8ccb4ea9a3ffe72ca41ba122ca8078a08f071ffbfb4ad56045bf22ed597fd76e821af',
                'revoked' => 0,
            ],
            9 => [
                'access_token_id' => 'e276dae74c5cbb77455793f1d5b886e7a54e7ad436580324159f1d8dc9ccafc968ffd42c78c6ab20',
                'expires_at' => '2023-01-14 00:38:41',
                'id' => '231e59c118def52ebcd348e89913bd4fc5c24c3314170828f14ca3eb78484f2319890b2e8e33122b',
                'revoked' => 0,
            ],
            10 => [
                'access_token_id' => '720cd9ce37a024045260472393e1a8f62b38688c8ceb99ef0afd2f9e95834292ee5044261c548929',
                'expires_at' => '2023-01-14 00:37:14',
                'id' => '2fa5ba5d6daa638a37b9df4e730fd6175c09709696739f432d5d0e8a0230de85694d4650501932f4',
                'revoked' => 0,
            ],
            11 => [
                'access_token_id' => 'd3d323ae1a5cf5667803c78dc0e55e7b76863df3c755700a0ffbdf0cdffed54612d1ac7c4cc055d5',
                'expires_at' => '2023-01-13 00:16:45',
                'id' => '3bee905f074561d2512fe0f0536f089586478f2a23f6c8ad3667f1c2a933de3cfecaa42da8b5ac00',
                'revoked' => 0,
            ],
            12 => [
                'access_token_id' => 'a1c7ebced519dde9d3a98de332c652accc04f047459410a0e2186c8375bf9b0838a334e9766e9273',
                'expires_at' => '2023-01-13 22:13:20',
                'id' => '420f63784130a5710b9e5c7ae7ba410fc3c394ecbb37ad30d78ca8f97b408558a4f4eecadef7f66d',
                'revoked' => 0,
            ],
            13 => [
                'access_token_id' => 'e2e8897d9c5bcd7444ef9e8a0bd1dff20859337b7a43463d7e072b348a70c66e69c8aa913ab49e68',
                'expires_at' => '2023-01-14 05:47:29',
                'id' => '42f85d52f7231ef1304cfbf704adf65d4d49392102bf0b674f13f78d53f7d314c8cc60bca7dbd9bd',
                'revoked' => 0,
            ],
            14 => [
                'access_token_id' => 'afda90a688f96a6a1ff01ac0dc03a9a61b97b52416046297ef6050d3aacae1eb80abf7ab4d8b0562',
                'expires_at' => '2023-01-13 22:33:14',
                'id' => '45178ca8bd7f9ee224b666d029945f4bb7d465b5e207786755263db8a9745163d67f11f473596285',
                'revoked' => 0,
            ],
            15 => [
                'access_token_id' => 'd0fac0b5fcbf3cfe917f8fe7893a6ac74e8f868b8841dfb997b19b9d886407bc566145f7cd9bd4f2',
                'expires_at' => '2023-01-13 00:18:33',
                'id' => '45f01ceab95fbec71a9bf11af22f2631857742d7b9573157ad30e76697f3594cd576a9ca136c97e1',
                'revoked' => 0,
            ],
            16 => [
                'access_token_id' => '5ebbce13d7268fa8060c095d2591412e42c2836fcbdb109cef1bef9602ed0ba7c75c34fa6d819547',
                'expires_at' => '2023-01-13 07:15:17',
                'id' => '464ad9b4cb67520ecd0f97ec4d4c1719c17f694943862cf28267bcc63c083788d6e60ddbb0c73856',
                'revoked' => 0,
            ],
            17 => [
                'access_token_id' => '76d98d81a3327c671a25aca58ae61ce1bf206ef912b8ee5f540c2ecbeb811edbd729265035bf6303',
                'expires_at' => '2023-01-13 00:29:45',
                'id' => '535660e04a54d3c36aecb051b8afc1d1ed9e40f2769ee0cb145ac7df60801cca36ba38355dedeb02',
                'revoked' => 0,
            ],
            18 => [
                'access_token_id' => '3b3815ccc6fb300fac65d42aedaac1852f1903d262d8cb7e81e8462ff500d7ea180d124d2bd80258',
                'expires_at' => '2023-01-14 05:33:02',
                'id' => '67d1244a9a89646476b71a05a63eeaf205c71d4e7c3fcb3cfa178aa5898e9b96be28aa7b4605762a',
                'revoked' => 0,
            ],
            19 => [
                'access_token_id' => '7ea8f98641575f9441177c5fbe95415a1442c84e10338ca6e5e288218bd37e4f1188667caa223bae',
                'expires_at' => '2023-01-14 00:49:59',
                'id' => '6a8065a83488fd3732c04ddc41e5d1e6d595af212375249f7fc0e6fb0549c70036f70cd229960865',
                'revoked' => 0,
            ],
            20 => [
                'access_token_id' => '078be571dd6ceb8751da8b2431571e3c6dbd5bf78425fa1d3f23771d82cc4889956379a99eb7e4af',
                'expires_at' => '2023-01-14 00:41:03',
                'id' => '6e51bb8c96c6fae05400a6b8507a609b352f05d4098bc578c02a8ff7ed4477bd441f4bb992f1c70f',
                'revoked' => 0,
            ],
            21 => [
                'access_token_id' => '88d101b8ca94cf119ca2cf833d3ff7da242adeb90bdc18858cedff1f365bc6966f38dc7a6eff0a47',
                'expires_at' => '2023-01-13 00:20:21',
                'id' => '7e80265f8eae1fcb1055703935a972220769dadd0d8e4c0c758ed01e94136f54205a419341c8bee3',
                'revoked' => 0,
            ],
            22 => [
                'access_token_id' => 'cf2a675e6d5b32ee3ffc16733b229ea6c3da330bf1d4957d71d464c0969fd1d25a11b7a4b7b522e8',
                'expires_at' => '2023-01-14 00:35:12',
                'id' => '7f1e893864bbd52b154d800b486c853eb8993cb4524c1f3cd78b95bef1a174d42681af6fe7e6d041',
                'revoked' => 0,
            ],
            23 => [
                'access_token_id' => 'e13117d398523527072879af10c4a8cd5addc8e22a5dce829d421c2db5578a5a7b3d7332f2cdea62',
                'expires_at' => '2023-01-14 01:18:36',
                'id' => '8080d4901a7d9bd2a870e2bb7b434bcc19e5cc90f73d678f34daedb8c8ae0400854c478e9b53d207',
                'revoked' => 0,
            ],
            24 => [
                'access_token_id' => 'aebc524603d64d0db324d39d0895bed3ebcfde94822f068e81d52db2ca74a763ea31e12fcc53fc1e',
                'expires_at' => '2023-01-13 00:21:25',
                'id' => '836d9f7f8243c6be215c734da38734b436f7f2a29afb38dc44f2a5564329cef9fcbc7d3ab454d092',
                'revoked' => 0,
            ],
            25 => [
                'access_token_id' => 'c14bc43cb58ceb5e7a9ec9316ed9921fa121ace8f0e17023e4d926551c92fcde8b449dc439a2eccd',
                'expires_at' => '2023-01-13 04:33:40',
                'id' => '868bcb2c1ce0bf8421cbe198e8e071cef58fe05ac039b541de6887612d3f1124ec697160b4923c95',
                'revoked' => 0,
            ],
            26 => [
                'access_token_id' => '16d13d24ac4ba24d118a583749a2bd523fdb1f020503be995858a4d25bcc5d7a6d1f2a6c505be968',
                'expires_at' => '2023-01-13 03:11:54',
                'id' => '9703bd2c6578ffed3a75ddc1e6fa1ab02fe24be422a42dfe2798ef2b29066c318623ce456e78dc9b',
                'revoked' => 0,
            ],
            27 => [
                'access_token_id' => 'be60202a4e34bb47552e31310906ed217442b5582531edd52557f684b8ce50c7e72a93316cd0e655',
                'expires_at' => '2023-01-14 05:31:24',
                'id' => '97aa1af41886f0c7f033ba6577163f0db64c0787d24c6fd4d184b031815786e0f0219870b09f939d',
                'revoked' => 0,
            ],
            28 => [
                'access_token_id' => 'deb5a5c98753f643e80a8f8e841d767c141b64b3985d5990b90bb9c427b8aff6f39d3a8bb570e704',
                'expires_at' => '2023-01-13 22:24:50',
                'id' => '9d183755c0b4590afc2986bc73d030bca06d12d5e2d7158a5d5e016138c6306b82e761b8a61088e5',
                'revoked' => 0,
            ],
            29 => [
                'access_token_id' => 'e5d488fc194bac6799846cc13a0f74859de357cf52a21f18e1624470e4f951849a29da2e9dfb22f4',
                'expires_at' => '2023-01-13 22:57:19',
                'id' => 'a338abb009f893f318ed6ba84a950da311157ba6e53dc900044c1fd56dffce534ed70c26688a1a50',
                'revoked' => 0,
            ],
            30 => [
                'access_token_id' => 'fa14c609d8b0882ee66e1bdcfbfccac633a8bad43db68f74392446ebc553dbb60baab5b9663664a9',
                'expires_at' => '2023-01-14 00:35:07',
                'id' => 'b43b372a7f875b35a500e0c54fa1267bf5e89d12b40ec9006f59e6daf8b44a56329cf84fa60031eb',
                'revoked' => 0,
            ],
            31 => [
                'access_token_id' => 'e4708a655b2a6c9d095c78dc69bbe6ccf2c9e17d86f25b685a8c837e2053e1cd2a8624b2ed762900',
                'expires_at' => '2023-01-13 00:14:02',
                'id' => 'bac685b6be4f2e284c5cf18fb7a47b703e0fd40f7b0d91bffb9019a23f9b37d379f9a2f057ec7eba',
                'revoked' => 0,
            ],
            32 => [
                'access_token_id' => 'dec8a407bc78cb31fb868f9118fbef77fbed9bb72edf4cab11dccace64c21885948fe7150188336e',
                'expires_at' => '2023-01-12 22:47:36',
                'id' => 'c3443a43fd48d869926e993afa36a042888f2d41a66407fd0b6a1f3d0446512db05f0d5d272e2901',
                'revoked' => 0,
            ],
            33 => [
                'access_token_id' => '22dc999bf1e7477d3237fb4617a921f6a3653498338b0e6b2fe982748f7d6913e0a43778ec8e1d31',
                'expires_at' => '2023-01-13 00:46:19',
                'id' => 'cbc7d08437c07ec913d1a67c424f1d244c34b5e70ef9b8e118e01d950046aed30c32b83447a09474',
                'revoked' => 0,
            ],
            34 => [
                'access_token_id' => '3da7bdc91134aa3c9a090cb6d58dbe0fa9165c7384064e58567045cf122cfb79d03f068301ee9853',
                'expires_at' => '2023-01-14 04:30:32',
                'id' => 'd0c4320cd87da334beb5f1ad77638db27e86200281339e2cbd09f5d2d382d1a50123c16ec997dcdb',
                'revoked' => 0,
            ],
            35 => [
                'access_token_id' => 'bf2b5f126131b67b3807d4be99157d3f166d198adf2c4d511a622427846676e2b34de4d1d7b87919',
                'expires_at' => '2023-01-14 00:47:58',
                'id' => 'd4635dbc94296899523f3d25905b2b192889d944cd7cb105e8f4ace9b51d3c7f799186441965893a',
                'revoked' => 0,
            ],
            36 => [
                'access_token_id' => '0ef8aa694fff0126736b4be40b790eadb6f398b7cf879c7a58d879067daac13daa136e51625c3f5f',
                'expires_at' => '2023-01-14 00:49:00',
                'id' => 'e1cec0720d9c94a9126f9146678b41171627a53d5e87d852ca5086812fd91fd529ea3ffa56feed11',
                'revoked' => 0,
            ],
            37 => [
                'access_token_id' => '09a4568e483928d65ba09ac344aa2408233507e9122e267adf7edcae714a6f73b60a45a78205a4b9',
                'expires_at' => '2023-01-13 22:48:36',
                'id' => 'e4885c944c7bfaa516bf9af075765215b3ccf12f759bc7e3f8f887fe9710e914c6d87de04f6b7552',
                'revoked' => 0,
            ],
            38 => [
                'access_token_id' => 'fc95e1a4ebd228777f0dd83b0c6b3334fe790fdc94ba7ed79341771af5fcd883e787bf6b3889d5c7',
                'expires_at' => '2023-01-13 02:14:07',
                'id' => 'f8881573e68090702f0540b5364930c4eb8eed9b8b9121ad463024ba3cd222a4da376a0e78fd9068',
                'revoked' => 0,
            ],
        ]);
    }
}
