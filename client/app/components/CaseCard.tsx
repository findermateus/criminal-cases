'use client';

import { ICases } from "@/types/cases";
import { MdEditSquare } from "react-icons/md";
import { FaTrashAlt } from "react-icons/fa";
import { FormEventHandler, useState } from "react";
import Modal from "./Modal";
import { useRouter } from "next/navigation";
import { deleteTodo, editTodo } from "@/api";


interface CasesProps {
    cases: ICases
}

const CaseCard: React.FC<CasesProps> = ({ cases }) => {
    const router = useRouter();
    const [openModalEdit, setOpenModalEdit] = useState<boolean>(false);
    const [openModalDelete, setOpenModalDelete] = useState<boolean>(false);
    const [tittleToEdit, setTittleToEdit] = useState<string>(cases.title);
    const [textToEdit, setTextToEdit] = useState<string>(cases.text);

    const handleSubmitEditTodo: FormEventHandler<HTMLFormElement> = async (e) => {
        e.preventDefault();
        await editTodo({
            id: cases.id,
            title: tittleToEdit,
            text: textToEdit
        });
        setTittleToEdit("");
        setTextToEdit("");
        setOpenModalEdit(false);
        router.refresh();
    };

    const handleDeleteTask = async (id: string) => {
        await deleteTodo(id);
        setOpenModalDelete(false);
        router.refresh();
    };

    function truncateText(text: string, maxLength: number): string {
        if (text.length <= maxLength) {
          return text;
        } else {
          return text.slice(0, maxLength).trim() + '...'; 
        }
      }

    return (
        <div className="card" style={{ width: '300px', height: '200px' }}>
            <div className="task-tittle">
                <h4 className="card-title">{truncateText(cases.title, 15)}</h4>
            </div>
            <div className="taks-desc">
                <h2 className="card-desc">{cases.text}</h2>
            </div>
            <div className="card-actions">
                <MdEditSquare onClick={() => setOpenModalEdit(true)} cursor="pointer" className="text-blue-500" size={25} />
                <FaTrashAlt onClick={() => setOpenModalDelete(true)} cursor="pointer" className="text-red-500" size={25} />
            </div>

            <Modal modalOpen={openModalEdit} setModalOpen={setOpenModalEdit}>
                <form onSubmit={handleSubmitEditTodo}>
                    
                    <div className="flex flex-col gap-5">
                        <h3 className="font-bold text-lg text-center">Edit Task</h3>
                        <input
                            value={tittleToEdit}
                            onChange={(e) => setTittleToEdit(e.target.value)}
                            type="text"
                            placeholder="Type the tittle here"
                            className="input input-bordered w-full"
                        />
                    
                        <input
                            value={textToEdit}
                            onChange={(e) => setTextToEdit(e.target.value)}
                            type="text"
                            placeholder="Type the desc here"
                            className="input input-bordered w-full"
                        />
                        <button type="submit" className="btn">Submit</button>
                    </div>
                </form>
            </Modal>

            <Modal modalOpen={openModalDelete} setModalOpen={setOpenModalDelete}>
                <h3 className="text-alg">Do you really want to delete this task?</h3>
                <div className="modal-action">
                    <button className="btn" onClick={() => handleDeleteTask(cases.id)}>
                        Yes
                    </button>
                </div>
            </Modal>
        </div>
    );
};

export default CaseCard;
