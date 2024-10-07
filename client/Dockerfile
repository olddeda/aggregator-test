FROM node:18

WORKDIR /client
ENV PATH ./node_modules/.bin/:$PATH

COPY package*.json ./
RUN npm ci
COPY . ./

EXPOSE 3000
EXPOSE 24678

CMD ["npm", "run", "dev"]
