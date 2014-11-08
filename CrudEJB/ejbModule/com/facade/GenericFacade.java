package com.facade;

public interface GenericFacade<T> {

	public abstract void save(T obj);

	public abstract T update(T obj);

	public abstract void delete(T obj);
}
