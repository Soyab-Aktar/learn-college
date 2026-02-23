#include <GL/glut.h>
int windowWidth = 600;
int windowHeight = 600;

void fillPixel(int pixelX, int pixelY, float fillColorRGB[3])
{
  glColor3fv(fillColorRGB);
  glBegin(GL_POINTS);
  glVertex2i(pixelX, pixelY);
  glEnd();
  glFlush();
}

void boundaryFILL(int pixelX, int pixelY, float fillColorRGB[3], float boundaryColorRGB[3])
{
  float currentPixelColor[3];
  glReadPixels(pixelX, pixelY, 1, 1, GL_RGB, GL_FLOAT, currentPixelColor);

  bool isBoundaryPixel =
      (currentPixelColor[0] == boundaryColorRGB[0] &&
       currentPixelColor[1] == boundaryColorRGB[1] &&
       currentPixelColor[2] == boundaryColorRGB[2]);

  bool isAlreadyFilled =
      (currentPixelColor[0] == fillColorRGB[0] &&
       currentPixelColor[1] == fillColorRGB[1] &&
       currentPixelColor[2] == fillColorRGB[2]);

  if (!isAlreadyFilled && !isBoundaryPixel)
  {
    fillPixel(pixelX, pixelY, fillColorRGB);

    boundaryFILL(pixelX + 1, pixelY, fillColorRGB, boundaryColorRGB);
    boundaryFILL(pixelX - 1, pixelY, fillColorRGB, boundaryColorRGB);
    boundaryFILL(pixelX, pixelY + 1, fillColorRGB, boundaryColorRGB);
    boundaryFILL(pixelX, pixelY - 1, fillColorRGB, boundaryColorRGB);
  }
}

void handleMouse(int button, int state, int mouseX, int mouseY)
{
  if (button == GLUT_LEFT_BUTTON && state == GLUT_DOWN)
  {
    float fillColorRGB[3] = {1.0f, 0.0f, 1.0f};
    float boundaryColorRGB[3] = {1.0f, 1.0f, 0.0f};

    int realMouseY = windowHeight - mouseY;

    boundaryFILL(mouseX, realMouseY, fillColorRGB, boundaryColorRGB);
  }
}

void drawPattern()
{
  glClear(GL_COLOR_BUFFER_BIT);

  glBegin(GL_LINE_LOOP);
  glColor3f(1.0, 1.0, 0.0);
  glVertex2i(50, 50);
  glVertex2i(300, 50);
  glVertex2i(300, 300);
  glVertex2i(50, 300);
  glEnd();

  glFlush();
}

void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0);
  glMatrixMode(GL_PROJECTION);
  glLoadIdentity();
  gluOrtho2D(0, windowWidth, 0, windowHeight);
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(windowWidth, windowHeight);
  glutCreateWindow("Boundary Fill Algorithm");
  init();
  glutDisplayFunc(drawPattern);
  glutMouseFunc(handleMouse);
  glutMainLoop();
}