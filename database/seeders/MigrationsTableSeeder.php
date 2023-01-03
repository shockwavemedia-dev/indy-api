<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('migrations')->delete();

        \DB::table('migrations')->insert([
            0 => [
                'batch' => 1,
                'id' => 1,
                'migration' => '2014_10_12_000000_create_users_table',
            ],
            1 => [
                'batch' => 1,
                'id' => 2,
                'migration' => '2014_10_12_100000_create_password_resets_table',
            ],
            2 => [
                'batch' => 1,
                'id' => 3,
                'migration' => '2016_06_01_000001_create_oauth_auth_codes_table',
            ],
            3 => [
                'batch' => 1,
                'id' => 4,
                'migration' => '2016_06_01_000002_create_oauth_access_tokens_table',
            ],
            4 => [
                'batch' => 1,
                'id' => 5,
                'migration' => '2016_06_01_000003_create_oauth_refresh_tokens_table',
            ],
            5 => [
                'batch' => 1,
                'id' => 6,
                'migration' => '2016_06_01_000004_create_oauth_clients_table',
            ],
            6 => [
                'batch' => 1,
                'id' => 7,
                'migration' => '2016_06_01_000005_create_oauth_personal_access_clients_table',
            ],
            7 => [
                'batch' => 1,
                'id' => 8,
                'migration' => '2019_08_19_000000_create_failed_jobs_table',
            ],
            8 => [
                'batch' => 1,
                'id' => 9,
                'migration' => '2019_12_14_000001_create_personal_access_tokens_table',
            ],
            9 => [
                'batch' => 1,
                'id' => 10,
                'migration' => '2022_01_21_025748_create_clients_table',
            ],
            10 => [
                'batch' => 1,
                'id' => 11,
                'migration' => '2022_01_21_030612_create_admin_users_table',
            ],
            11 => [
                'batch' => 1,
                'id' => 12,
                'migration' => '2022_01_21_033415_create_client_users_table',
            ],
            12 => [
                'batch' => 1,
                'id' => 13,
                'migration' => '2022_01_21_035706_create_departments_table',
            ],
            13 => [
                'batch' => 1,
                'id' => 14,
                'migration' => '2022_01_21_041113_create_admin_departments_table',
            ],
            14 => [
                'batch' => 1,
                'id' => 15,
                'migration' => '2022_01_23_214530_create_files_table',
            ],
            15 => [
                'batch' => 1,
                'id' => 16,
                'migration' => '2022_01_24_030208_create_tickets_table',
            ],
            16 => [
                'batch' => 1,
                'id' => 17,
                'migration' => '2022_01_24_031614_create_ticket_emails_table',
            ],
            17 => [
                'batch' => 1,
                'id' => 18,
                'migration' => '2022_01_24_032426_create_ticket_email_attachments_table',
            ],
            18 => [
                'batch' => 1,
                'id' => 19,
                'migration' => '2022_01_24_032459_create_ticket_assignees_table',
            ],
            19 => [
                'batch' => 1,
                'id' => 20,
                'migration' => '2022_01_24_032531_create_ticket_events_table',
            ],
            20 => [
                'batch' => 1,
                'id' => 21,
                'migration' => '2022_01_25_220909_create_client_ticket_files_table',
            ],
            21 => [
                'batch' => 1,
                'id' => 22,
                'migration' => '2022_01_26_235451_create_file_feedbacks_table',
            ],
            22 => [
                'batch' => 1,
                'id' => 23,
                'migration' => '2022_01_26_243735_create_file_feedback_attachments_table',
            ],
            23 => [
                'batch' => 1,
                'id' => 24,
                'migration' => '2022_02_02_223233_create_jobs_table',
            ],
            24 => [
                'batch' => 1,
                'id' => 25,
                'migration' => '2022_02_27_221153_create_services_table',
            ],
            25 => [
                'batch' => 1,
                'id' => 26,
                'migration' => '2022_02_27_221322_create_client_services_table',
            ],
            26 => [
                'batch' => 1,
                'id' => 27,
                'migration' => '2022_02_27_222022_create_ticket_event_services_table',
            ],
            27 => [
                'batch' => 1,
                'id' => 28,
                'migration' => '2022_03_06_221000_create_library_categories_table',
            ],
            28 => [
                'batch' => 1,
                'id' => 29,
                'migration' => '2022_03_06_221305_create_libraries_table',
            ],
            29 => [
                'batch' => 1,
                'id' => 30,
                'migration' => '2022_03_15_233327_alter_ticket_events_add_column',
            ],
            30 => [
                'batch' => 1,
                'id' => 31,
                'migration' => '2022_03_16_220509_alter_files_add_column_bucket',
            ],
            31 => [
                'batch' => 1,
                'id' => 32,
                'migration' => '2022_03_23_220141_create_lead_clients_table',
            ],
            32 => [
                'batch' => 1,
                'id' => 33,
                'migration' => '2022_03_23_223417_alter_users_table',
            ],
            33 => [
                'batch' => 1,
                'id' => 34,
                'migration' => '2022_04_19_215544_create_ticket_event_attachments_table',
            ],
            34 => [
                'batch' => 1,
                'id' => 35,
                'migration' => '2022_04_19_220109_alter_ticket_events_table_remove_column',
            ],
            35 => [
                'batch' => 1,
                'id' => 36,
                'migration' => '2022_04_26_215059_create_ticket_activities_table',
            ],
            36 => [
                'batch' => 1,
                'id' => 37,
                'migration' => '2022_04_27_023200_alter_ticket_assignees_table_add_column',
            ],
            37 => [
                'batch' => 1,
                'id' => 38,
                'migration' => '2022_04_27_050959_alter_ticket_column',
            ],
            38 => [
                'batch' => 1,
                'id' => 39,
                'migration' => '2022_04_28_015450_alter_ticket_emails_message_to_json',
            ],
            39 => [
                'batch' => 1,
                'id' => 40,
                'migration' => '2022_05_02_045716_create_ticket_notes_table',
            ],
            40 => [
                'batch' => 1,
                'id' => 41,
                'migration' => '2022_05_11_001218_alter_ticket_emails_column',
            ],
            41 => [
                'batch' => 1,
                'id' => 42,
                'migration' => '2022_05_11_031226_create_email_logs_table',
            ],
            42 => [
                'batch' => 1,
                'id' => 43,
                'migration' => '2022_05_17_232437_create_department_services_table',
            ],
            43 => [
                'batch' => 1,
                'id' => 44,
                'migration' => '2022_05_18_034449_create_ticket_assignee_links_table',
            ],
            44 => [
                'batch' => 1,
                'id' => 45,
                'migration' => '2022_05_20_012023_alter_ticket_assignee_link_table',
            ],
            45 => [
                'batch' => 1,
                'id' => 46,
                'migration' => '2022_05_24_234141_create_error_logs_table',
            ],
            46 => [
                'batch' => 1,
                'id' => 47,
                'migration' => '2022_05_31_000801_alter_table_name_ticket_services',
            ],
            47 => [
                'batch' => 1,
                'id' => 48,
                'migration' => '2022_06_10_000753_create_support_requests_table',
            ],
            48 => [
                'batch' => 1,
                'id' => 49,
                'migration' => '2022_06_10_012049_create_support_request_chats_table',
            ],
            49 => [
                'batch' => 1,
                'id' => 50,
                'migration' => '2022_06_15_004325_create_notifications_table',
            ],
            50 => [
                'batch' => 1,
                'id' => 51,
                'migration' => '2022_06_21_022204_add_column_to_table_ticket_assignee',
            ],
            51 => [
                'batch' => 1,
                'id' => 52,
                'migration' => '2022_06_23_032914_add_column_to_files_table',
            ],
            52 => [
                'batch' => 1,
                'id' => 53,
                'migration' => '2022_07_01_015749_alter_notification_users',
            ],
            53 => [
                'batch' => 1,
                'id' => 54,
                'migration' => '2022_07_07_000053_add_column_custom_fields',
            ],
            54 => [
                'batch' => 1,
                'id' => 55,
                'migration' => '2022_07_08_005205_create_folders_table',
            ],
            55 => [
                'batch' => 1,
                'id' => 56,
                'migration' => '2022_07_11_025431_alter_files_table',
            ],
            56 => [
                'batch' => 1,
                'id' => 57,
                'migration' => '2022_07_12_033649_create_marketing_planners_table',
            ],
            57 => [
                'batch' => 1,
                'id' => 58,
                'migration' => '2022_07_12_044329_create_marketing_planner_attachments_table',
            ],
            58 => [
                'batch' => 1,
                'id' => 59,
                'migration' => '2022_07_12_045227_alter_tickets_table',
            ],
            59 => [
                'batch' => 1,
                'id' => 60,
                'migration' => '2022_07_20_000842_create_events_table',
            ],
            60 => [
                'batch' => 1,
                'id' => 61,
                'migration' => '2022_07_24_230831_add_column_to_events_table',
            ],
            61 => [
                'batch' => 1,
                'id' => 62,
                'migration' => '2022_07_26_022937_add_folder_id_column_to_events_table',
            ],
            62 => [
                'batch' => 1,
                'id' => 63,
                'migration' => '2022_07_27_042956_alter_department_manager_column_to_events_table',
            ],
            63 => [
                'batch' => 1,
                'id' => 64,
                'migration' => '2022_07_29_034012_add_ip_column_to_oauth_access_tokens_table',
            ],
            64 => [
                'batch' => 1,
                'id' => 65,
                'migration' => '2022_07_29_052441_add_photographer_id_to_events_table',
            ],
            65 => [
                'batch' => 1,
                'id' => 66,
                'migration' => '2022_08_02_040049_create_marketing_planner_tasks_table',
            ],
            66 => [
                'batch' => 1,
                'id' => 67,
                'migration' => '2022_08_07_235810_remove_columns_to_marketing_planner_table',
            ],
            67 => [
                'batch' => 1,
                'id' => 68,
                'migration' => '2022_08_15_220911_create_printers_table',
            ],
            68 => [
                'batch' => 1,
                'id' => 69,
                'migration' => '2022_08_16_051810_add_deleted_at_to_users_table',
            ],
            69 => [
                'batch' => 1,
                'id' => 70,
                'migration' => '2022_08_17_012256_add_logo_file_id_designated_designer_id_to_clients_table',
            ],
            70 => [
                'batch' => 1,
                'id' => 71,
                'migration' => '2022_08_17_231246_remove_column_logo_to_clients_table',
            ],
            71 => [
                'batch' => 1,
                'id' => 72,
                'migration' => '2022_08_18_015627_create_mailbox_inbound_emails_table',
            ],
            72 => [
                'batch' => 1,
                'id' => 73,
                'migration' => '2022_08_18_232556_add_owner_id_column_to_clients_table',
            ],
            73 => [
                'batch' => 1,
                'id' => 74,
                'migration' => '2022_08_23_034346_add_column_notify_to_marketing_planner_tasks_table',
            ],
            74 => [
                'batch' => 1,
                'id' => 75,
                'migration' => '2022_08_25_063452_add_columns_long_text_to_clients_table',
            ],
            75 => [
                'batch' => 1,
                'id' => 76,
                'migration' => '2022_08_29_113134_add_thumbnail_path_to_files_table',
            ],
            76 => [
                'batch' => 1,
                'id' => 77,
                'migration' => '2022_09_01_002220_create_social_media_table',
            ],
            77 => [
                'batch' => 1,
                'id' => 78,
                'migration' => '2022_09_01_005854_create_social_media_attachments_table',
            ],
            78 => [
                'batch' => 1,
                'id' => 79,
                'migration' => '2022_09_01_011317_create_social_media_activities_table',
            ],
            79 => [
                'batch' => 1,
                'id' => 80,
                'migration' => '2022_09_01_013306_create_social_media_comments_table',
            ],
            80 => [
                'batch' => 1,
                'id' => 81,
                'migration' => '2022_09_12_030015_create_audits_table',
            ],
            81 => [
                'batch' => 1,
                'id' => 82,
                'migration' => '2022_09_14_000013_add_column_ticket_id_to_social_media_table',
            ],
            82 => [
                'batch' => 1,
                'id' => 83,
                'migration' => '2022_09_20_014439_alter_fields_nullable_to_users_table',
            ],
            83 => [
                'batch' => 1,
                'id' => 84,
                'migration' => '2022_10_04_010407_add_column_priority_to_tickets_table',
            ],
            84 => [
                'batch' => 1,
                'id' => 85,
                'migration' => '2022_10_06_003754_create_printer_jobs_table',
            ],
            85 => [
                'batch' => 1,
                'id' => 86,
                'migration' => '2022_10_06_004534_add_column_campaign_type_to_social_media_table',
            ],
            86 => [
                'batch' => 1,
                'id' => 87,
                'migration' => '2022_10_11_223204_add_column_printer_id_to_clients_table',
            ],
            87 => [
                'batch' => 1,
                'id' => 88,
                'migration' => '2022_10_14_054332_add_column_is_approved_to_printer_jobs_table',
            ],
            88 => [
                'batch' => 1,
                'id' => 89,
                'migration' => '2022_10_17_232431_alter_field_is_approved_to_printer_jobs_table',
            ],
            89 => [
                'batch' => 1,
                'id' => 90,
                'migration' => '2022_10_18_223914_create_marketing_planner_task_assignees_table',
            ],
            90 => [
                'batch' => 1,
                'id' => 91,
                'migration' => '2022_10_19_223750_create_screens_table',
            ],
            91 => [
                'batch' => 1,
                'id' => 92,
                'migration' => '2022_10_20_231238_add_screen_id_to_clients_table',
            ],
            92 => [
                'batch' => 1,
                'id' => 93,
                'migration' => '2022_10_25_210544_create_client_screens_table',
            ],
            93 => [
                'batch' => 1,
                'id' => 94,
                'migration' => '2022_10_26_221122_add_column_position_to_admin_departments_table',
            ],
            94 => [
                'batch' => 1,
                'id' => 95,
                'migration' => '2022_10_27_224743_add_field_profile_to_users_table',
            ],
            95 => [
                'batch' => 1,
                'id' => 96,
                'migration' => '2022_11_04_025718_alter_foreign_key_admin_user_id_to_client_ticket_files_table',
            ],
            96 => [
                'batch' => 1,
                'id' => 97,
                'migration' => '2022_11_07_040825_update_all_tickets_table',
            ],
            97 => [
                'batch' => 1,
                'id' => 98,
                'migration' => '2022_11_09_010531_create_printer_job_attachments',
            ],
            98 => [
                'batch' => 1,
                'id' => 99,
                'migration' => '2022_11_09_020907_alter_printer_jobs_table',
            ],
            99 => [
                'batch' => 1,
                'id' => 100,
                'migration' => '2022_11_09_024503_add_email_description_to_tickets_table',
            ],
            100 => [
                'batch' => 1,
                'id' => 101,
                'migration' => '2022_11_18_043513_add_column_seen_to_tickets_table',
            ],
            101 => [
                'batch' => 1,
                'id' => 102,
                'migration' => '2022_11_24_024841_add_designated_personnel_column_to_clients_table',
            ],
            102 => [
                'batch' => 1,
                'id' => 103,
                'migration' => '2022_11_28_044638_create_ticket_file_versions_table',
            ],
            103 => [
                'batch' => 1,
                'id' => 104,
                'migration' => '2022_11_29_020341_add_ticket_file_to_ticket_notes_table',
            ],
            104 => [
                'batch' => 1,
                'id' => 105,
                'migration' => '2022_12_01_012354_add_column_is_approval_required_to_tickets_table',
            ],
            105 => [
                'batch' => 1,
                'id' => 106,
                'migration' => '2022_12_05_040400_add_column_client_id_to_files_table',
            ],
            106 => [
                'batch' => 1,
                'id' => 107,
                'migration' => '2022_12_14_231946_create_ticket_chats_table',
            ],
            107 => [
                'batch' => 2,
                'id' => 108,
                'migration' => '2022_12_19_000250_create_note_attachments_table',
            ],
            108 => [
                'batch' => 3,
                'id' => 109,
                'migration' => '2022_12_20_014411_add_postdate_to_ticket_services_table',
            ],
        ]);
    }
}
