from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware  # 👈 THÊM DÒNG NÀY
from app.api.v1 import chatbot

app = FastAPI()

# 👇 THÊM PHẦN NÀY
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # hoặc ["http://localhost:3000"] nếu muốn giới hạn
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Router
app.include_router(chatbot.router, prefix="/api/v1", tags=["Chatbot"])






