import { HttpInterceptorFn } from '@angular/common/http';

export const tenantInterceptor: HttpInterceptorFn = (req, next) => {
  const host = window.location.host;
  const sub = host.split('.').length >= 3 ? host.split('.')[0] : null;
  const cloned = sub ? req.clone({ setHeaders: { 'X-Tenant': sub } }) : req;
  return next(cloned);
};
