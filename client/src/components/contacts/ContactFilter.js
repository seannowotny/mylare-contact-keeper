

import React, { useContext, useRef, useEffect } from 'react';
import ContactContext from '../../context/contact/contactContext';

import type { ContactContextType } from '../../context/contact/ContactState';

const ContactFilter = () => {
  const { filterContacts, clearFilter, filtered }: ContactContextType = useContext(ContactContext);
  const text = useRef({value: ''});

  useEffect(() => {
    if(filtered === null)
    {
      text.current.value = '';
    }
  });

  const onChange = e => {
    if(text.current.value !== '')
    {
      filterContacts(e.target.value);
    }
    else
    {
      clearFilter();
    }
  };

  return (
    <form>
      <input
      ref={text} 
      type="text" 
      placeholder="Filter Contacts..." 
      onChange={onChange}
      />
    </form>
  )
};

export default ContactFilter
