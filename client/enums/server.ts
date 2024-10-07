export enum ServerStatusCode {
	Ok = 200,
	Created = 201,
	NoContent = 201,
	BadRequest = 400,
	Unauthorized = 401,
	Forbidden = 403,
	NotFound = 404,
	UnprocessableContent = 422,
	ToEarly = 425,
	ToManyRequests = 429
}