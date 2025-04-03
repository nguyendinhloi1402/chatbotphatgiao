# app/main.py

from fastapi import FastAPI
from app.api.v1 import chatbot

app = FastAPI()

# Đăng ký router cho chatbot với prefix "/api/v1" và gán tag "Chatbot"
app.include_router(chatbot.router, prefix="/api/v1", tags=["Chatbot"])





