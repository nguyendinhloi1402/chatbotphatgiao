# Chuẩn bị dữ liệu
from ingestion.ingestion import Ingestion


Ingestion("openai").ingestion_folder(
    path_input_folder="demo/data_in",  # Đọc dữ liệu từ thư mục data_in
    path_vector_store="demo/data_vector"  # Lưu trữ các vector vào thư mục data_vector
)

# Các dòng mã còn lại:
from chatbot.services.files_chat_agent import FilesChatAgent  # noqa: E402
from app.config import settings

# Cấu hình mô hình LLM bạn muốn sử dụng (OpenAI trong trường hợp này)
settings.LLM_NAME = "openai"

# Câu hỏi người dùng muốn hỏi
_question = "Trong cuộc đời, có ba điều quan trọng mà chúng ta cần ghi nhớ là gì?"

# Tạo đối tượng FilesChatAgent và thực hiện quy trình hỏi-đáp
chat = FilesChatAgent("demo/data_vector").get_workflow().compile().invoke(
    input={
        "question": _question,
    }
)

# In kết quả chat ra màn hình
print(chat)
print("generation", chat["generation"])
