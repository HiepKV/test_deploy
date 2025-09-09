import { userRepository } from './userRepository';
import { postRepository } from './postRepository';

export const repositories = {
  user: userRepository,
  post: postRepository,
};
