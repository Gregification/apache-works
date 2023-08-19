<?php
    namespace private_request\DB;
    enum PsqlChatEnum : string {
        case DATABASE           = 'chatdb';

        case SCHEMA             = 'public';
        case SCHEMA_CHAT        = 'chats';

        case CHATIDPREFIX       = '_';

        case TABLE_IMAGE        = PsqlChatEnum::SCHEMA->value.'._images';
        case TABLE_USER         = PsqlChatEnum::SCHEMA->value.'._users';
        case TABLE_CHATS        = PsqlChatEnum::SCHEMA->value.'._chats';
        case TABLE_CHAT_TEMPLATE        = PsqlChatEnum::SCHEMA->value.'._chattemplate';

        case USER_COLUMNS_CON   = 'private_request\DB\PsqlEnum.USER_COLUMNS_CON';
            case USER_COLUMN_LASTACTIVETIME = 'lastactivetime';
            case USER_COLUMN_CREATIONTIME   = 'creationtime';
            case USER_COLUMN_USERNAME       = 'username';
            case USER_COLUMN_DESCRIPTION    = 'description';
            
            case USER_COLUMN_USERNAME_CHARLIMIT     = '255';
            case USER_COLUMN_DESCRIPTION_CHARLIMIT  = '1500';
        
        case CHATS_COLUMNS_CON          = 'private_request\DB\PsqlEnum.CHATS_COLUMNS_CON';
            case CHATS_COLUMN_TITLE         = 'title';
            case CHATS_COLUMN_LASTACTIVETIME    = 'lastactivetime';
            case CHATS_COLUMN_CREATIONTIME  = 'creationtime';
            case CHATS_COLUMN_DESCRIPTION   = 'description';
            case CHATS_COLUMN_USERSONLINE   = 'usersonline';
            case CHATS_COLUMN_ID            = 'id';
            
            case CHATS_TITLE_CHATLIMIT      = '255';
        
        case CHAT_COLUMNS_CON     = 'private_request\DB\PsqlEnum.CHATS_COLUMNS_CON';
            case CHAT_COLUMN_TIMEDELIVERED  = 'timedelivered';
            case CHAT_COLUMN_MESSAGE        = 'message';
            case CHAT_COLUMN_BY             = 'by';
        
            case CHAT_MESSAGE_CHATLIMIT     = '2000';
    }

    define(PsqlChatEnum::USER_COLUMNS_CON->value, array(
        PsqlChatEnum::USER_COLUMN_USERNAME      ->value,
        PsqlChatEnum::USER_COLUMN_LASTACTIVETIME->value,
        PsqlChatEnum::USER_COLUMN_CREATIONTIME  ->value,
        PsqlChatEnum::USER_COLUMN_DESCRIPTION   ->value
        ));

    define(PsqlChatEnum::CHATS_COLUMNS_CON->value, array(
        PsqlChatEnum::CHATS_COLUMN_TITLE        ->value,
        PsqlChatEnum::CHATS_COLUMN_LASTACTIVETIME   ->value,
        PsqlChatEnum::CHATS_COLUMN_CREATIONTIME ->value,
        PsqlChatEnum::CHATS_COLUMN_DESCRIPTION  ->value,
        PsqlChatEnum::CHATS_COLUMN_USERSONLINE  ->value,
        PsqlChatEnum::CHATS_COLUMN_ID           ->value
        ));

    define(PsqlChatEnum::CHAT_COLUMNS_CON->value, array(
        PsqlChatEnum::CHAT_COLUMN_TIMEDELIVERED ->value,
        PsqlChatEnum::CHAT_COLUMN_MESSAGE       ->value,
        PsqlChatEnum::CHAT_COLUMN_BY            ->value
        ));
?>