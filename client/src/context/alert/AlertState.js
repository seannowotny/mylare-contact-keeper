// @flow

import React, { useReducer } from 'react';
import uuid from 'uuid';
import AlertContext from './alertContext';
import alertReducer from './alertReducer';

import type { Alert } from './alertReducer';

export type AlertStates = Alert[];

type Dispatch = (Alert) => any;
//#endregion

const AlertState = (props: any) => 
{
   const initialState: AlertStates = [];

   const [state, dispatch]: [any, Dispatch] = useReducer(alertReducer, initialState);

   // Set Alert
   const setAlert = (msg, type, timeout = 5000) => {
       const id = parseInt(uuid.v4());
       dispatch({
           type: 'SET_ALERT',
           payload: { msg, type, id }
       });

       setTimeout(() => dispatch({ type: 'REMOVE_ALERT', payload: id }), timeout);
   }

   return (
    <AlertContext.Provider
      value={{ 
        alerts: state,
        setAlert
      }}
    >
      { props.children }
    </AlertContext.Provider>
   );
};

export default AlertState;