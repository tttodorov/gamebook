package com.facade.impl;

import com.dao.ClubDAO;
import com.facade.ClubFacade;
import com.model.Club;

import javax.ejb.EJB;
import javax.ejb.Stateless;

@Stateless
public class ClubFacadeImpl implements ClubFacade {

	@EJB
	private ClubDAO clubDAO;

	@Override
	public void save(Club club) {
		valid(club);

		clubDAO.save(club);
	}

	@Override
	public Club update(Club club) {
		valid(club);

		return clubDAO.update(club);
	}

	@Override
	public void delete(Club club) {
		clubDAO.delete(club.getId(), Club.class);
	}

	private void valid(Club club) {
		// TODO throw IllegalArgumentException, if player is not correct
	}

}
