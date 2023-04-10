import {insertError} from "../components/flash";

export function throwError(error) {
    insertError(error);
    throw new Error(error).stack;
}
