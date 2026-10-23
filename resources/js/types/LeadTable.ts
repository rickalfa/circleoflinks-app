export type LeadAttentionStatus =
    | 'WAITING_HUMAN'
    | 'HUMAN_ACTIVE'
    | 'BOT_ACTIVE'
    | 'CLOSED'
    | 'NO_CONVERSATION';

export interface LeadContact {
    is_contact: boolean;
    user_app_id: number | null;
    name: string | null;
    email: string | null;
    address: string | null;
    phone_number: string | null;
    status_name: string | null;
}

export interface LeadAssignedUser {
    id: number;
    name: string;
    is_me?: boolean;
}

export interface LeadAttention {
    conversation_id: number | null;
    status: LeadAttentionStatus;
    raw_status: 'bot_active' | 'human_active' | 'closed' | null;
    assigned_user: LeadAssignedUser | null;
    since: string | null;
    last_message_preview: string | null;
}

export interface LeadRow {
    id: number;
    name: string;
    phone_number: string;
    avatar_url: string | null;
    last_message_time: string | null;
    unread_messages_count: number;
    has_unread_messages: boolean;
    contact: LeadContact;
    attention: LeadAttention;
}

export interface PaginationMeta {
    current_page: number;
    per_page: 5 | 10;
    last_page: number;
    total: number;
    from: number | null;
    to: number | null;
    waiting_human_count: number;
}

export interface PaginatedLeadsResponse {
    data: LeadRow[];
    meta: PaginationMeta;
}
