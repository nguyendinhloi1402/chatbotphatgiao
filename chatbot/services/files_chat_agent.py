from chatbot.utils.llm import LLM  # noqa: I001
from chatbot.utils.retriever import Retriever
from chatbot.utils.document_grader import DocumentGrader
from chatbot.utils.answer_generator import AnswerGenerator
from chatbot.utils.no_answer_handler import NoAnswerHandler
from langgraph.graph import END, StateGraph, START
from chatbot.utils.graph_state import GraphState
from typing import Dict, Any
from app.config import settings

class FilesChatAgent:
    """
    Lớp FilesChatAgent chịu trách nhiệm quản lý quy trình chatbot,
    từ tìm kiếm tài liệu, đánh giá độ liên quan đến tạo câu trả lời và xuất kết quả HTML.
    """

    def __init__(self, path_vector_store: str) -> None:
        """
        Khởi tạo FilesChatAgent với các thành phần chính.
        """
        self.retriever = Retriever(settings.LLM_NAME).set_retriever(path_vector_store)
        self.llm = LLM().get_llm(settings.LLM_NAME)
        self.document_grader = DocumentGrader(self.llm)
        self.answer_generator = AnswerGenerator(self.llm)
        self.no_answer_handler = NoAnswerHandler(self.llm)

    def retrieve(self, state: GraphState) -> Dict[str, Any]:
        """
        Phương thức tìm kiếm tài liệu liên quan đến câu hỏi.
        """
        question = state["question"]
        documents = self.retriever.get_documents(question, int(settings.NUM_DOC))
        return {"documents": documents, "question": question}

    def generate(self, state: GraphState) -> Dict[str, Any]:
        """
        Tạo câu trả lời dựa trên các tài liệu liên quan.
        """
        question = state["question"]
        documents = state["documents"]
        context = "\n\n".join(doc.page_content for doc in documents)
        generation = self.answer_generator.get_chain().invoke({"question": question, "context": context})

        if not generation:
            raise Exception("Generation failed, no response received.")
        
        return {"generation": generation, "question": question}

    def grade_documents(self, state: GraphState) -> Dict[str, Any]:
        """
        Chấm điểm tài liệu để xác định mức độ liên quan.
        """
        # Implement your grading logic here
        pass

    def handle_no_answer(self, state: GraphState) -> Dict[str, Any]:
        """
        Xử lý khi không có câu trả lời.
        """
        # Implement logic to handle no answer case
        pass

    def decide_to_generate(self, state: GraphState) -> str:
        """
        Quyết định xem có cần tạo câu trả lời không.
        """
        if not state["documents"]:
            return "no_document"
        return "generate"

    def get_workflow(self):
        """
        Thiết lập luồng xử lý của chatbot, bao gồm các bước tìm kiếm, đánh giá và tạo câu trả lời.
        """
        workflow = StateGraph(GraphState)
        workflow.add_node("retrieve", self.retrieve)
        workflow.add_node("grade_documents", self.grade_documents)
        workflow.add_node("generate", self.generate)
        workflow.add_node("handle_no_answer", self.handle_no_answer)

        workflow.add_edge(START, "retrieve")
        workflow.add_edge("retrieve", "grade_documents")

        workflow.add_conditional_edges(
            "grade_documents",
            self.decide_to_generate,
            {
                "no_document": "handle_no_answer",
                "generate": "generate",
            },
        )

        workflow.add_edge("generate", END)

        return workflow
