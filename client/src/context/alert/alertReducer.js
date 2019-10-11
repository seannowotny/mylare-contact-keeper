// @flow

export type AlertType = 'SET_ALERT' | 'REMOVE_ALERT';

export type Alert = {|
    type: AlertType,
    payload: {| 
        msg: string, 
        type: string, 
        id: number 
    |} | number;
|};

export default(state: any, action: Alert) => {
  switch(action.type) 
  {
    case 'SET_ALERT':
      return [...state, action.payload]
    case 'REMOVE_ALERT':
      return state.filter(alert => alert.id !== action.payload);
    default:
      return state;
  }
}