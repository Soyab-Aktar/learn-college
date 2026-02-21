#include <GL/glut.h>
void dimondTop()
{
  glBegin(GL_TRIANGLES);
  glColor3f(1.0, 0.0, 0.0); // Red vertex
  glVertex2f(-0.8, 0.0);

  glColor3f(0.0, 1.0, 0.0); // Green vertex
  glVertex2f(0.8, 0.0);

  glColor3f(0.0, 0.0, 1.0); // Blue vertex
  glVertex2f(0.0, 0.9);
  glEnd();
}
void dimondBottom()
{
  glBegin(GL_TRIANGLES);
  glColor3f(1.0, 0.0, 0.0); // Red vertex
  glVertex2f(-0.8, 0.0);

  glColor3f(0.0, 1.0, 0.0); // Green vertex
  glVertex2f(0.8, 0.0);

  glColor3f(0.0, 0.0, 1.0); // Blue vertex
  glVertex2f(0.0, -0.9);
  glEnd();
}

void display()
{
  glClearColor(0.0, 0.0, 0.0, 1.0);
  glClear(GL_COLOR_BUFFER_BIT);

  dimondTop();
  dimondBottom();

  glFlush();
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(500, 500);
  glutCreateWindow("Traiangle Pattern");
  glutDisplayFunc(display);
  glutMainLoop();
  return 0;
}