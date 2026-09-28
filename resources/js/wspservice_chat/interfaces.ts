export interface UserApp {
    id: number;
    name: string;
}

export interface ChatMessage {
    id: number;
    conversation_id: number;
    sender_type: 'user' | 'agent' | 'admin';
    content: string;
    sent_at: string;
}

export interface Lead {
    id: number;
    name: string;
    phone_number: string;
    last_message_time?: string;
    state?: string;
    user_id?: number;
    avatar_url?: string;
}

export interface Conversation {
    id: number;
    user_id: number;
    agent_id: number | null;
    status: 'bot_active' | 'human_active' | 'closed';
    messages: ChatMessage[];
}

export interface ConversationResponse {
    conversation: Conversation;
    lead: Lead;
}

