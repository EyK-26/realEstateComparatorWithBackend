import React, {
    ChangeEvent,
    FormEvent,
    useContext,
    useState,
    FunctionComponent,
} from "react";
import UserContext from "../../myApp/context/UserContext";
import axios from "axios";
import Messages from "../../components/Messages";

const ManualReset: FunctionComponent = () => {
    const { state, dispatch } = useContext(UserContext);
    const [values, setValues] = useState({
        id: typeof state.user === "object" && state.user?.id,
        password: "",
        password_confirmation: "",
    });

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();
        try {
            const response = await axios.put(
                "/api/manual-reset/action",
                values
            );
            if (Math.floor(response.status / 100) === 2) {
                dispatch({
                    type: "messages/set",
                    payload: [response.data.message],
                });
                setValues((prev) => ({
                    ...prev,
                    password: "",
                    password_confirmation: "",
                }));
            }
        } catch (error: any) {
            const { password, password_confirmation } =
                error.response.data.errors || false;
            if (password || password_confirmation) {
                dispatch({
                    type: "messages/set",
                    payload: [password, password_confirmation],
                });
            }
        }
    };

    const handleChange = (e: ChangeEvent<HTMLInputElement>): void => {
        setValues((prev) => ({
            ...prev,
            [e.target.name]: e.target.value,
        }));
    };

    return (
        <div className="reset_password">
            <form onSubmit={handleSubmit}>
                <label htmlFor="password">New password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    onChange={handleChange}
                    value={values.password}
                />
                <label htmlFor="password_confirmation">
                    Confirm new password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    onChange={handleChange}
                    value={values.password_confirmation}
                />
                <button type="submit">Reset</button>
            </form>
            <Messages />
        </div>
    );
};

export default ManualReset;