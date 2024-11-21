'use client';

import { AiOutlinePlus } from "react-icons/ai";
import Modal from "./Modal";
import { FormEventHandler, useState } from "react";
import { addTodo } from "@/api";
import { useRouter } from "next/navigation";
import { v4 as uuidv4 } from 'uuid'; 

const AddCase = () => {
    const router = useRouter();
    const [modalOpen, setModalOpen] = useState<boolean>(false);
    const [newTitleValue, setNewTittleValue] = useState<string>('');
    const [newDescValue, setNewDescValue] = useState<string>('');

    const handleSubmitNewTodo: FormEventHandler<HTMLFormElement> = async (e) => {
        e.preventDefault();
        await addTodo({
            id: uuidv4(),
            title: newTitleValue,
            text: newDescValue
        });
        setNewTittleValue("");
        setModalOpen(false);
        router.refresh();
    }

    return (
        <div>
            <button onClick={() => setModalOpen(true)} className="btn btn-primary w-full uppercase">
                Add new task <AiOutlinePlus size={18} className="ml-1" />
            </button>

            <Modal modalOpen={modalOpen} setModalOpen={setModalOpen}>
                <form onSubmit={handleSubmitNewTodo}>
                    <div className="flex flex-col gap-5">
                        <h3 className="font-bold text-lg">Add new task</h3>
                        <input
                            value={newTitleValue}
                            onChange={(e) => setNewTittleValue(e.target.value)}
                            type="text"
                            placeholder="Type the tittle here"
                            className="input input-bordered w-full"
                        />
                        <input
                            value={newDescValue}
                            onChange={(e) => setNewDescValue(e.target.value)}
                            type="text"
                            placeholder="Type the desc here"
                            className="input input-bordered w-full"
                        />
                        <button type="submit" className="btn">Submit</button>
                    </div>
                </form>
            </Modal>
        </div>
    );
};

export default AddCase;
