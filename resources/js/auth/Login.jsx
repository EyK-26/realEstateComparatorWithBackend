import React, { useContext, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import Context from "../myApp/Context/Context";
import axios from "axios";

const Login = () => {
    const [values, setValues] = useState({
        email: "",
        password: "",
    });
    const { state, dispatch } = useContext(Context);
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post("/login", values);
            if (Math.floor(response.status / 100) === 2) {
                dispatch({
                    type: "user/set",
                    payload: response.data,
                });
                navigate("/");
            }
        } catch (error) {
            dispatch({
                type: "error/set",
                payload: error.response.data.errors,
            });
        }
    };

    const handleChange = (e) => {
        setValues((prev) => ({
            ...prev,
            [e.target.name]: e.target.value,
        }));
    };

    return (
        <>
            {state.error.length > 0 &&
                state.error.map((el, i) => <span key={i}>{el}</span>)}
            <form onSubmit={handleSubmit}>
                <label htmlFor="email">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value={values.email}
                    onChange={handleChange}
                />
                <label htmlFor="password">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    value={values.password}
                    onChange={handleChange}
                />
                <input type="submit" value="Login" />
            </form>
            <span>
                <Link to="/forgot-password">Forgot Password</Link>
            </span>
            <span>
                You don't have an account?{" "}
                <Link to="/register">Register Now</Link>
            </span>
        </>
    );
};

export default Login;