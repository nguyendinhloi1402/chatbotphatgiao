# app/config.py

import os

class Settings:
    LLM_NAME = os.getenv("LLM_NAME", "openai")
    NUM_DOC = os.getenv("NUM_DOC", "3")
    KEY_API_GPT = os.getenv("KEY_API_GPT")
    OPENAI_LLM = os.getenv("OPENAI_LLM", "gpt-4o-mini")

settings = Settings()
