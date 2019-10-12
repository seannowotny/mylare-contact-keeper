// @flow

import React, { useReducer } from 'react';
import axios from 'axios';
import ContactContext from './contactContext';
import contactReducer from './contactReducer';

import type { Action } from './contactReducer';

//#region types
export type Contact = {|
   id: number,
   type: "personal" | "professional",
   name: string,
   email: string,
   phone: string
|}

export type ContactsState = {|
   contacts: Contact[],
   current: ?Contact,
   filtered: ?Contact[],
   error: ?string
|}

export type ContactContextType = 
ContactsState & {|
   addContact: (Contact) => null,
   deleteContact: (number) => null,
   setCurrent: (Contact) => null,
   clearCurrent: () => null,
   updateContact: (Contact) => null,
   filterContacts: (string) => null,
   clearFilter: () => null
|}

type Dispatch = (Action) => any;
//#endregion

const ContactState = (props: any) => 
{
   const initialState: ContactsState = 
   {
      contacts: [],
      current: null,
      filtered: null,
      error: null
   };

   // state allows us to access anything in our state and dispatch allows us to dispatch objects to the reducer
   const [state, dispatch]: [any, Dispatch] = useReducer(contactReducer, initialState);

   // Get Contacts
   const getContacts = async (contact: Contact) => {
      try {
         const res = await axios.get('/api/contacts');

         dispatch({ 
            type: 'GET_CONTACTS', 
            payload: res.data 
         });
      } catch(err) {
         dispatch({ 
            type: 'CONTACT_ERROR',
            payload: err.response.msg
         });
      }
   }

   // Add Contact
   const addContact = async (contact: Contact) => {
      const config = {
         headers: {
            'Content-Type': 'application/json'
         }
      };

      try {
         const res = await axios.post('/api/contacts', contact, config);

         dispatch({ 
            type: 'ADD_CONTACT', 
            payload: res.data 
         });
      } catch(err) {
         dispatch({ 
            type: 'CONTACT_ERROR',
            payload: err.response.msg
         });
      }
   }

   // Delete Contact
   const deleteContact = async (id: number) => {
      try {
         const res = await axios.delete(`/api/contacts/${id}`);

         dispatch({ 
            type: 'DELETE_CONTACT', 
            payload: id 
         });
      } catch(err) {
         dispatch({ 
            type: 'CONTACT_ERROR',
            payload: err.response.msg
         });
      }
   }

   // Update Contact
   const updateContact = async (contact: Contact) => {
      const config = {
         headers: {
            'Content-Type': 'application/json'
         }
      };

      try {
         const res = await axios.put(`/api/contacts/${contact.id}`, contact, config);

         dispatch({ 
            type: 'UPDATE_CONTACT', 
            payload: res.data
         });
      } catch(err) {
         dispatch({ 
            type: 'CONTACT_ERROR',
            payload: err.response.msg
         });
      }
   }

   // Clear Contacts
   const clearContacts = () => {
      dispatch({ type: 'CLEAR_CONTACTS', payload: {} });
   }

   // Set Current Contact
   const setCurrent = (contact: Contact) => {
      dispatch({ type: 'SET_CURRENT', payload: contact });
   }

   // Clear Current Contact
   const clearCurrent = () => {
      dispatch({ type: 'CLEAR_CURRENT', payload: {} });
   }

   // Filter Contacts
   const filterContacts = (text:string) => {
      dispatch({ type: 'FILTER_CONTACTS', payload: text });
   }

   // Clear Filter
   const clearFilter = () => {
      dispatch({ type: 'CLEAR_FILTER', payload: {} });
   }

   return (
      <ContactContext.Provider
         value={{ 
            contacts: state.contacts,
            current: state.current,
            filtered: state.filtered,
            error: state.error,
            addContact,
            deleteContact,
            setCurrent,
            clearCurrent,
            updateContact,
            filterContacts,
            clearFilter,
            getContacts,
            clearContacts
          }}>
         { props.children }
      </ContactContext.Provider>
   );
};

export default ContactState;