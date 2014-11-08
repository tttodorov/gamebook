package com.dao;

import java.util.Date;
import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;

public abstract class GenericDAO<T> {
	private final static String UNIT_NAME = "CrudPU";

	private final Date createdOn;

	@PersistenceContext(unitName = UNIT_NAME)
	private EntityManager em;
	private Class<T> entityClass;
	private int id;
	private int isActive;
	private Date lastEditedOn;

	public GenericDAO(Class<T> entityClass) {
		this.entityClass = entityClass;
		this.createdOn = new Date();
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getIsActive() {
		return isActive;
	}

	public void setIsActive(int isActive) {
		if (isActive == 0 || isActive == 1) {
			this.isActive = isActive;
		} else {
			// TODO add log message
		}
	}

	public Date getCreatedOn() {
		return createdOn;
	}

	public Date getLastEditedOn() {
		return lastEditedOn;
	}

	public void setLastEditedOn(Date lastEditedOn) {
		long lastEditionTime = this.lastEditedOn.getTime();
		long newLastEditionTime = lastEditedOn.getTime();

		if (lastEditionTime - newLastEditionTime < 0) {
			this.lastEditedOn = lastEditedOn;
		} else {
			// TODO add log message
		}
	}

	public void save(T entity) {
		em.persist(entity);
	}

	protected void delete(Object id, Class<T> classe) {
		T entityToBeRemoved = em.getReference(classe, id);

		em.remove(entityToBeRemoved);
	}

	public T update(T entity) {
		return em.merge(entity);
	}

	public T find(int entityID) {
		return em.find(entityClass, entityID);
	}

	// // Using the unchecked because JPA does not have a
	// // em.getCriteriaBuilder().createQuery()<T> method
	// @SuppressWarnings({ "unchecked", "rawtypes" })
	// public List<T> findAll() {
	// CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
	// cq.select(cq.from(entityClass));
	// return em.createQuery(cq).getResultList();
	// }
	//
	// // Using the unchecked because JPA does not have a
	// // ery.getSingleResult()<T> method
	// @SuppressWarnings("unchecked")
	// protected T findOneResult(String namedQuery, Map<String, Object>
	// parameters) {
	// T result = null;
	//
	// try {
	// Query query = em.createNamedQuery(namedQuery);
	//
	// // Method that will populate parameters if they are passed not null
	// // and empty
	// if (parameters != null && !parameters.isEmpty()) {
	// populateQueryParameters(query, parameters);
	// }
	//
	// result = (T) query.getSingleResult();
	//
	// } catch (Exception e) {
	// System.out.println("Error while running query: " + e.getMessage());
	// e.printStackTrace();
	// }
	//
	// return result;
	// }
	//
	// private void populateQueryParameters(Query query,
	// Map<String, Object> parameters) {
	//
	// for (Entry<String, Object> entry : parameters.entrySet()) {
	// query.setParameter(entry.getKey(), entry.getValue());
	// }
	// }
}