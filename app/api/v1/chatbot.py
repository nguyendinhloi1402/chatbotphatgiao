from fastapi import APIRouter
from pydantic import BaseModel
from chatbot.services.files_chat_agent import FilesChatAgent
from app.config import settings

router = APIRouter()

class ChatRequest(BaseModel):
    question: str

@router.post("/chat")
def chat_with_bot(request: ChatRequest):
    settings.LLM_NAME = "openai"  # hoặc "gemini" nếu bạn dùng Gemini
    chat = FilesChatAgent("demo/data_vector").get_workflow().compile().invoke(
        input={"question": request.question}
    )
    return {"answer": chat["generation"]}
