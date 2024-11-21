import React from 'react';

interface ModalProps {
    modalOpen: boolean;
    setModalOpen: (open: boolean) => void;
    children: React.ReactNode;
}

const Modal: React.FC<ModalProps> = ({ modalOpen, setModalOpen, children }) => {
    return (
        <>
            {modalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div className="modal-box relative bg-white p-6 rounded-lg shadow-lg">
                        <button
                            onClick={() => setModalOpen(false)}
                            aria-label="Close modal"
                            className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        >
                            ✕
                        </button>
                        {children}
                    </div>
                </div>
            )}
        </>
    );
};

export default Modal;